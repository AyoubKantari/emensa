#  E-Mensa Web-App

**PHP MVC Projekt – DBWT Praktikum | FH Aachen**

> Eine webbasierte Mensa-Anwendung entwickelt im Rahmen des Praktikums "Datenbanken und Web-Technologien" (DBWT) an der FH Aachen.

---

##  Team

| Vorname | Nachname |
|---------|----------|
| Ayoub   | Kantari  | 
| Aymen   | Radi     | 



---

## 📋 Projektübersicht

Die E-Mensa App ermöglicht Studierenden, das Mensaangebot online einzusehen, sich anzumelden und Bewertungen zu lesen. Das Projekt folgt dem **MVC-Architekturprinzip** und verwendet **Blade** als Template-Engine.

### Features
- 🗂️ MVC-Architektur mit eigenem Routing-System
- 🎨 Blade-Templates für alle Views
- 🗄️ MariaDB-Datenbankanbindung mit prepared statements
- 🔐 Session-basiertes Login/Logout
- 🛡️ XSS- und SQL-Injection-Schutz
- 📝 Newsletter-Anmeldung mit Validierung
- ⭐ Gerichtsbewertungen und Filterung

---

## 🚀 Installation & Start

### Voraussetzungen

- PHP >= 7.4
- MariaDB / MySQL
- Composer

### 1. Projekt klonen

```bash
git clone https://github.com/AyoubKantari/emensa.git
cd emensa
```

### 2. Abhängigkeiten installieren

```bash
composer install
```

### 3. Datenbank einrichten

```bash
# MariaDB starten und einloggen
mysql -u root -p

# Datenbank erstellen
CREATE DATABASE emensa;
USE emensa;

# SQL-Dump importieren (falls vorhanden)
SOURCE database/emensa.sql;
```

### 4. Konfiguration anpassen

Datei `config/database.php` bearbeiten:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'emensa');
define('DB_USER', 'root');
define('DB_PASS', 'dein_passwort');
```

### 5. Server starten

**Option A – Windows (Batch-Datei):**
```
start_server.bat
```

**Option B – Kommandozeile (alle OS):**
```bash
php -S 127.0.0.1:9000 -t public
```

### 6. Im Browser öffnen

```
http://127.0.0.1:9000/
```

---

##  Projektstruktur

```
emensa/
├── beispiele/          # PHP-Übungsaufgaben (M2 Aufgaben 5–8)
├── config/             # Konfigurationsdateien (DB, App-Einstellungen)
├── controllers/        # Controller-Klassen (MVC)
├── models/             # Model-Klassen (Datenbankzugriff)
├── public/             # Web-Root (index.php + statische Dateien)
│   ├── index.php       # Einstiegspunkt + Router
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript-Dateien
│   └── img/            # Bilder / Gerichtsfotos
├── routes/             # Routing-Tabelle (routes.php)
├── storage/            # Blade-Cache (automatisch generiert)
├── views/              # Blade-Template-Dateien (.blade.php)
├── composer.json       # PHP-Abhängigkeiten
├── start_server.bat    # Windows Server-Startskript
└── README.md           # Diese Datei
```

---

## 🔀 Routing

Das Routing erfolgt über `public/index.php` und die Routing-Tabelle in `routes/routes.php`.

**Beispiel-Routen:**

| URL | Controller | Methode |
|-----|------------|---------|
| `/` | HomeController | index() |
| `/gerichte` | GerichtController | index() |
| `/gericht/{id}` | GerichtController | show() |
| `/login` | AuthController | showLogin() |
| `/login` (POST) | AuthController | login() |
| `/logout` | AuthController | logout() |
| `/newsletter` (POST) | NewsletterController | store() |

---

## 🏗️ MVC-Architektur

```
Browser
   │
   ▼
public/index.php  ──── routes/routes.php
   │
   ▼
Controller (controllers/)
   │           │
   ▼           ▼
Model        View
(models/)   (views/*.blade.php)
   │
   ▼
MariaDB
```

**Controller** empfangen Anfragen, rufen Models auf und übergeben Daten an Views.

**Models** kapseln die Datenbanklogik und liefern Daten zurück.

**Views** (Blade-Templates) stellen die Daten dar.

---

## 🔐 Sicherheit

- **SQL-Injection**: Alle DB-Abfragen verwenden **prepared statements** (`mysqli_prepare` / PDO)
- **XSS**: Alle Ausgaben werden mit `htmlspecialchars()` oder Blade's `{{ }}` escaped
- **Session-Schutz**: `session_regenerate_id(true)` nach Login
- **Passwort-Hashing**: `password_hash()` und `password_verify()`

---

## 📧 Newsletter-Validierung

Die Newsletter-Anmeldung prüft:
-  Name darf nicht leer sein (kein Whitespace-only)
-  Datenschutzbestimmung muss akzeptiert sein
-  E-Mail muss gültigem Format entsprechen (`filter_var()`)
-  Keine Wegwerf-E-Mails von `wegwerfmail.de` oder `trashmail.*`

---

##  Abhängigkeiten

| Paket | Version | Zweck |
|-------|---------|-------|
| `eftec/bladeone` | ^4.x | Blade-Template-Engine |

---

## 📌 Hinweise

- Der `storage/`-Ordner muss **schreibbar** sein (Blade-Cache)
- PHP-Fehlerausgabe in der Entwicklung: `error_reporting(E_ALL)` in `config/`
- Für **Produktivbetrieb**: Debug-Ausgaben deaktivieren

---

## 📚 Verwendete Technologien

- **PHP 7.4+** – Serversprache
- **MariaDB** – Relationale Datenbank
- **Blade (BladeOne)** – Template-Engine
- **HTML5 / CSS3** – Frontend
- **MVC Pattern** – Architektur

---

*Erstellt im Rahmen des DBWT-Praktikums, FH Aachen*
