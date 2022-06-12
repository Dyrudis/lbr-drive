<?php
include("../database.php");
session_start();

if ($_SESSION['role'] != 'admin') {
    die("Vous n'avez pas les droits pour accéder aux logs");
}

// Récupération des logs
try {
    $stmt = $mysqli->prepare("SELECT IDSource, Nom, Prenom, Date, log.Description FROM log, utilisateur WHERE log.IDSource = utilisateur.IDUtilisateur ORDER BY Date DESC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

echo json_encode($result->fetch_all(MYSQLI_ASSOC));
