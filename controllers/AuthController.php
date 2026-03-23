<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/../models/benutzer.php');

class AuthController
{
    /**
     * Anmeldeformular anzeigen
     */
    public function index(RequestData $request) {
        $fehler = $_SESSION['anmeldung_fehler'] ?? null;
        unset($_SESSION['anmeldung_fehler']);

        return view('anmeldung', [
            'fehler' => $fehler
        ]);
    }

    /**
     * Anmeldung verifizieren
     */
    public function verifizieren(RequestData $request) {
        $data = $request->getPostData();
        $email = $data['email'] ?? '';
        $passwort = $data['passwort'] ?? '';

        if (empty($email) || empty($passwort)) {
            $_SESSION['anmeldung_fehler'] = 'Bitte alle Felder ausfüllen!';
            header('Location: /anmeldung');
            exit;
        }

        $benutzer = db_benutzer_find_by_credentials($email, $passwort);

        if ($benutzer) {
            $this->anmeldungErfolgreich($benutzer);
        } else {
            $this->anmeldungFehlgeschlagen($email);
        }
    }

    /**
     * Erfolgreiche Anmeldung behandeln
     */
    private function anmeldungErfolgreich($benutzer) {
        db_benutzer_log_erfolg($benutzer['id']);

        $_SESSION['angemeldet'] = true;
        $_SESSION['benutzer_id'] = $benutzer['id'];
        $_SESSION['benutzer_name'] = $benutzer['name'];
        $_SESSION['benutzer_email'] = $benutzer['email'];
        $_SESSION['ist_admin'] = $benutzer['admin'];

        // LOGGING: Erfolgreiche Anmeldung
        logger()->info('Benutzer erfolgreich angemeldet', [
            'benutzer_id' => $benutzer['id'],
            'email' => $benutzer['email'],
            'name' => $benutzer['name'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);

        $ziel = $_SESSION['ziel'] ?? '/';
        unset($_SESSION['ziel']);

        header('Location: ' . $ziel);
        exit;
    }

    /**
     * Fehlgeschlagene Anmeldung behandeln
     */
    private function anmeldungFehlgeschlagen($email) {
        db_benutzer_log_fehler($email);

        // LOGGING: Fehlgeschlagene Anmeldung
        logger()->warning('Anmeldung fehlgeschlagen', [
            'email' => $email,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);

        $_SESSION['anmeldung_fehler'] = 'E-Mail oder Passwort falsch!';

        header('Location: /anmeldung');
        exit;
    }

    /**
     * Abmeldung
     */
    public function abmelden(RequestData $request) {
        $benutzer_id = $_SESSION['benutzer_id'] ?? null;
        $benutzer_name = $_SESSION['benutzer_name'] ?? 'Unbekannt';

        // LOGGING: Abmeldung
        logger()->info('Benutzer abgemeldet', [
            'benutzer_id' => $benutzer_id,
            'name' => $benutzer_name,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);

        $_SESSION = array();

        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }

        session_destroy();

        header('Location: /');
        exit;
    }

    /**
     * Profilseite
     */
    public function profil(RequestData $request) {
        if (!isset($_SESSION['angemeldet']) || !$_SESSION['angemeldet']) {
            $_SESSION['ziel'] = '/profil';
            header('Location: /anmeldung');
            exit;
        }

        $benutzer = db_benutzer_find_by_id($_SESSION['benutzer_id']);

        return view('profil', [
            'benutzer' => $benutzer
        ]);
    }
}
