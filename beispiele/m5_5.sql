-- Meilenstein 5 - Aufgabe 5: Stored Procedures
-- Autor: Ayoub Kantari, Aymen Radi
-- Datum: 19.12.2025

DELIMITER //
CREATE PROCEDURE increment_anmeldungszaehler(IN benutzer_id INT)
BEGIN
UPDATE benutzer
SET anzahlanmeldungen = anzahlanmeldungen + 1,
    letzteanmeldung = NOW()
WHERE id = benutzer_id;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE increment_fehlerzaehler(IN benutzer_email VARCHAR(255))
BEGIN
UPDATE benutzer
SET anzahlfehler = anzahlfehler + 1,
    letzterfehler = NOW()
WHERE email = benutzer_email;
END//
DELIMITER ;
