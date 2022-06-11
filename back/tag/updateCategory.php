<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour mettre à jour cette catégorie");
}

$IDCategorie = $_POST['IDCategorie'];
$name = $_POST['name'];
$color = $_POST['color'];

include("../database.php");

try {
    // Récupération de l'ancien nom et couleur de la catégorie pour les logs
    $stmt = $mysqli->prepare("SELECT NomCategorie, Couleur FROM categorie WHERE IDCategorie = ?");
    $stmt->bind_param("i", $IDCategorie);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldName = $row['NomCategorie'];
        $oldColor = $row['Couleur'];
    }

    // Modification de la catégorie dans la base de données
    $stmt = $mysqli->prepare("UPDATE categorie SET NomCategorie = ?, Couleur = ? WHERE IDCategorie = ?");
    $stmt->bind_param("ssi", $name, $color, $IDCategorie);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie modifiée : " . $oldName . " → " . $name . ", #" . $oldColor . " → #" . $color);

die("OK");
