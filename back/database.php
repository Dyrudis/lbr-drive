<?php

// Activation des rapports d'erreurs
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Connexion à la base de données
try {
    $mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');
} catch (mysqli_sql_exception $e) {
    // return error in utf8
    die('Erreur de connexion à la base de données : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
