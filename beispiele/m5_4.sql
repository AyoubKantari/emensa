-- Meilenstein 5 - Aufgabe 4: SQL Views
-- Autor: Ayoub Kantari, Aymen Radi
-- Datum: 19.12.2025

CREATE VIEW view_suppengerichte AS
SELECT id, name, beschreibung, preisintern, preisextern, bildname
FROM gericht
WHERE name LIKE '%suppe%';

CREATE VIEW view_anmeldungen AS
SELECT id, name, email, anzahlanmeldungen, anzahlfehler, letzteanmeldung, letzterfehler
FROM benutzer
ORDER BY anzahlanmeldungen DESC;

CREATE VIEW view_kategoriegerichte_vegetarisch AS
SELECT k.id AS kategorie_id, k.name AS kategorie_name, g.id AS gericht_id, g.name AS gericht_name, g.vegetarisch
FROM kategorie k
         LEFT JOIN gericht_hat_kategorie ghk ON k.id = ghk.kategorie_id
         LEFT JOIN gericht g ON ghk.gericht_id = g.id AND g.vegetarisch = 1
ORDER BY k.name, g.name;
