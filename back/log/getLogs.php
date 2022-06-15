<?php
include("../database.php");
session_start();

if ($_SESSION['role'] != 'admin') {
    die("Vous n'avez pas les droits pour accéder aux logs");
}

// Récupération des logs
try {
    $result = query("SELECT IDSource, Nom, Prenom, Date, log.Description FROM log, utilisateur WHERE log.IDSource = utilisateur.IDUtilisateur ORDER BY Date DESC");
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

echo json_encode($result);
