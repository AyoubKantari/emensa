<?php
/**
 * Alle Datenbankfunktionen für Benutzer
 */

// Salt - MUSS identisch zu beispiele/passwort.php sein!
const SALT = "emensa_dbwt_2025_fh_aachen";

/**
 * Benutzer anhand E-Mail und Passwort finden
 */
function db_benutzer_find_by_credentials($email, $passwort) {
    $link = connectdb();
    $passwort_hash = sha1(SALT . $passwort);
    $stmt = mysqli_prepare($link,
        "SELECT * FROM benutzer WHERE email = ? AND passwort = ?"
    );
    mysqli_stmt_bind_param($stmt, 'ss', $email, $passwort_hash);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $benutzer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    return $benutzer;
}

/**
 * Benutzer anhand ID finden
 */
function db_benutzer_find_by_id($id) {
    $link = connectdb();
    $stmt = mysqli_prepare($link, "SELECT * FROM benutzer WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $benutzer = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    return $benutzer;
}

/**
 * Erfolgreiche Anmeldung protokollieren
 */
function db_benutzer_log_erfolg($id) {
    $link = connectdb();
    mysqli_begin_transaction($link);
    try {
        $stmt = mysqli_prepare($link, "CALL increment_anmeldungszaehler(?)" );
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $stmt2 = mysqli_prepare($link, "UPDATE benutzer SET anzahlfehler = 0 WHERE id = ?");
        mysqli_stmt_bind_param($stmt2, 'i', $id);
        $result2 = mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
        if ($result && $result2) {
            mysqli_commit($link);
            mysqli_close($link);
            return true;
        } else {
            throw new Exception("Datenbankfehler");
        }
    } catch (Exception $e) {
        mysqli_rollback($link);
        mysqli_close($link);
        return false;
    }
}

/**
 * Fehlgeschlagene Anmeldung protokollieren
 */
function db_benutzer_log_fehler($email) {
    $link = connectdb();
    $stmt = mysqli_prepare($link, "CALL increment_fehlerzaehler(?)" );
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
