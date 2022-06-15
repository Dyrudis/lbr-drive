<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour mettre à jour ce tag");
}

$IDTag = $_POST['IDTag'];
$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

if ($IDTag == '0') {
    die("Vous ne pouvez pas modifier le tag \"Sans tag\"");
}



include("../database.php");

try {
    // Si c'est un invité on vérifie qu'il a accès au tag
    if ($_SESSION['role'] == 'invite') {
        $id = $_SESSION['id'];

        $stmt = $mysqli->prepare("SELECT * FROM restreindre WHERE IDTag = ? AND IDUtilisateur = ?");
        $stmt->bind_param("ii", $IDTag, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            die("Vous n'avez pas accès à ce tag en tant qu'invité");
        }
    }

    // Récupération de l'ancien nom et catégorie du tag pour les logs
    $stmt = $mysqli->prepare("SELECT NomTag, NomCategorie FROM tag, categorie WHERE tag.IDCategorie = categorie.IDCategorie AND IDTag = ?");
    $stmt->bind_param("i", $IDTag);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldName = $row['NomTag'];
        $oldCategorie = $row['NomCategorie'];
    }

    // Récupération de la nouvelle catégorie du tag pour les logs
    $stmt = $mysqli->prepare("SELECT NomCategorie FROM categorie WHERE IDCategorie = ?");
    $stmt->bind_param("i", $IDCategorie);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categorie = $row['NomCategorie'];
    }

    
    

    // Modification du tag dans la base de données
    $stmt = $mysqli->prepare("UPDATE tag SET NomTag = ?, IDCategorie = ? WHERE IDTag = ?");
    $stmt->bind_param("sii", $name, $IDCategorie, $IDTag);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag modifié : " . $oldName . " → " . $name . ", " . $oldCategorie . " → " . $categorie);

die("OK");
