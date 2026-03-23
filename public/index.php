<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0);

session_start();
const VERBOSITY = 0;

const PUBLIC_DIRNAME = "public";
const CONFIG_WEBROUTES = "/../routes/web.php";
const CONFIG_DB = "/../config/db.php";
const ROUTER_VERSION = '0.8.5';

assert_php_version('8.2.0');
assert_path();

try {
    if (!file_exists(realpath($_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php"))) {
        echo "<h1>Abhängigkeiten nicht gefunden</h1><pre>DOCUMENT_ROOT: {$_SERVER['DOCUMENT_ROOT']}</pre><br><p>Datei nicht gefunden: <strong>{$_SERVER['DOCUMENT_ROOT']}/../vendor/autoload.php</strong></p>";
        echo "<p>Häufigste Ursache</p><ul>
            <li>Das Verzeichnis <code>public/</code> ist <em>nicht</em> als Wurzelverzeichnis verwendet worden.</li>
            <li>Die Abhängigkeiten wurden nicht mit <code>composer update</code> installiert.</code></li>
            </ul>";
        exit(1);
    }
    require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php");

} catch (Exception $ex) {
    echo "<code>DOCUMENT_ROOT</code><br><pre>{$_SERVER['DOCUMENT_ROOT']}</pre><code>Error</code><br><pre>" . $ex->getMessage() . "</pre>";
}

use eftec\bladeone\BladeOne;

$verbosity = VERBOSITY;
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    if ($verbosity > 1) {
        echo
            "<pre>Verbosity-Level: <strong>{$verbosity}</strong></pre>" .
            "<pre>" . print_r($_SERVER, 1) . "</pre><hr>";
    }
    FrontController::handleRequest("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", $_SERVER['REQUEST_METHOD'], VERBOSITY);
}

class RequestData
{
    public array $query;
    public array $args;
    public string $method;

    public function getData() { return array_merge($_GET, $_POST); }
    public function getPostData() { return $_POST; }
    public function getGetData() { return $_GET; }
    public function getRequestUri() { return $_SERVER['REQUEST_URI']; }
    public function getFiles() { return $_FILES; }

    public function __construct($method, $args, $query)
    {
        $this->query = $query;
        $this->args = $args;
        $this->method = $method;
    }
}

class FrontController
{
    public static function handleRequest($url, $method = 'GET', $verbosity = 0, $configPath = CONFIG_WEBROUTES)
    {
        assert_blade();

        if (!str_contains($url, ':')) $url = $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];

        $scriptPath = dirname(__FILE__, 2) . '/';
        $controllerDirectory = $scriptPath . 'controllers/';
        $config = FrontController::getConfig($configPath);
        $request = parse_url($url);
        $ctrlName = $request['path'];
        $actionName = 'index';
        $args = array();
        $query = array();
        parse_str($request['query'] ?? "", $query);

        if ($method != 'GET')
            $query = array_merge($query, $_REQUEST);

        if (strpos($ctrlName, '/', 1) > 0) {
            $path = explode('/', $request['path']);
            array_shift($path);
            $ctrlName = array_shift($path);
            $actionName = array_shift($path);
            $args = $path;
        }

        $ctrlName = trim($ctrlName, '/');
        $actionName = trim($actionName, '/');

        if (array_key_exists('/' . $ctrlName . '/' . $actionName, $config)) {
            $routingConfig = explode('@', $config['/' . $ctrlName . '/' . $actionName]);
            $ctrlClass = $routingConfig[0];
            $actionName = $routingConfig[1];
        } elseif (array_key_exists($request['path'], $config)) {
            $routingConfig = explode('@', $config[$request['path']]);
            $ctrlClass = $routingConfig[0];
            $actionName = $routingConfig[1];
        } else {
            $ctrlClass = ucfirst($ctrlName . 'Controller');
        }

        $ctrlFile = ($ctrlClass . '.php');
        $validControllers = FrontController::getValidControllers($controllerDirectory);
        if (!in_array($controllerDirectory . $ctrlFile, $validControllers)) {
            FrontController::showErrorMessage("<h1>Web Software Error</h1><p>Keine entsprechende Zuordnung für {$ctrlName}::{$actionName}.</p>");
        }

        try {
            require_once $controllerDirectory . $ctrlFile;
            $controller = new $ctrlClass();
            $rd = new RequestData($method, $args, $query);
            print call_user_func_array(array($controller, $actionName), array($rd));
        } catch (Exception $ex) {
            FrontController::showErrorMessage(
                "<h2>Fehler in Controller " . get_class($controller) . "!</h2><p>" . $ex->getMessage() . "</p>");
        }
    }

    public static function showErrorMessage($text, $severity = 3, $die = true)
    {
        $style = "background-color: #F08170; border: 2px solid lightgray; padding: 2em; margin: 5em; width: 50%;";
        print("<div style=\"{$style}\">{$text}</div>");
        if ($die) exit($severity);
    }

    public static function getConfig($configPath)
    {
        try {
            $path_to_config = realpath($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $configPath);
            $config = include $path_to_config;
        } catch (Exception $e) {
            $config = array('/' => 'HomeController@index');
        } finally {
            return $config;
        }
    }

    public static function getValidControllers($path = '')
    {
        if ($path == '') {
            $path = getcwd() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        }
        return glob($path . '*Controller.php');
    }
}

function connectdb()
{
    $path_to_config_db = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . CONFIG_DB;
    $config = include $path_to_config_db;
    $link = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database'], $config['port'] ?? 3306);
    if (!$link) {
        FrontController::showErrorMessage("<h1>Verbindung mit der Datenbank nicht möglich</h1><p>" . mysqli_connect_error() . "</p>");
        exit(1);
    }
    return $link;
}

function view($viewname, $viewargs = array())
{
    $views = dirname(__DIR__) . '/views';
    $cache = dirname(__DIR__) . '/storage/cache';
    $blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
    return $blade->run($viewname, $viewargs);
}

function assert_php_version($minversion = '8.0.0')
{
    $version_too_low = 0;
    $minver = explode('.', $minversion);
    $version = explode('.', phpversion());
    if (intval($minver[0]) > intval($version[0])) { $version_too_low = 1; }
    elseif (intval($minver[1]) > intval($version[1])) { $version_too_low = 1; }
    elseif (intval($minver[2]) > intval($version[2])) { $version_too_low = 1; }
    if ($version_too_low) {
        FrontController::showErrorMessage("PHP Version zu niedrig: Minimum " . $minversion);
        exit(1);
    }
}

function assert_path(): void
{
    static $chars = array("[", "]", "{", "}");
    $charsfound = 0;
    str_ireplace($chars, '', $_SERVER['DOCUMENT_ROOT'], $charsfound);
    if ($charsfound > 0) {
        FrontController::showErrorMessage("<h1>Bitte verwenden Sie einen anderen Ordner!</h1><p>Pfad enthält problematische Zeichen.</p>");
        exit(1);
    }
}

function assert_blade(): void
{
    if (!class_exists('eftec\bladeone\BladeOne')) {
        FrontController::showErrorMessage("<h1>Fehler: Blade wurde nicht gefunden</h1><p>Führen Sie <code>php bin/composer.phar update</code> aus.</p>");
        exit(1);
    }
    function logger() {
        static $logger = null;
        if ($logger === null) {
            $logger = new \Monolog\Logger('emensa');
            $logFile = dirname(__DIR__) . '/storage/logs/app.log';
            $handler = new \Monolog\Handler\StreamHandler($logFile, \Monolog\Level::Info);
            $logger->pushHandler($handler);
        }
        return $logger;
    }
}
