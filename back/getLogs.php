<?php
include("./database.php");
session_start();

if ($_SESSION['role'] != 'admin') {
    die("Vous n'avez pas les droits pour accéder aux logs");
}

// Prepare the query
$sql = $mysqli->prepare("SELECT IDSource, Nom, Prenom, Date, log.Description FROM log, utilisateur WHERE log.IDSource = utilisateur.IDUtilisateur ORDER BY Date DESC");
$sql->execute();

// Return as an array
echo json_encode($sql->get_result()->fetch_all(MYSQLI_ASSOC));