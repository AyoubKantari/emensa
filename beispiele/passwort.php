<?php

$salt = "emensa_dbwt_2025_fh_aachen";
$passwort = "admin123";
$hash = sha1($salt . $passwort);

echo "=== PASSWORT HASH GENERATOR ===\n\n";
echo "Salt: " . $salt . "\n";
echo "Passwort: " . $passwort . "\n";
echo "Hash: " . $hash . "\n\n";
?>
