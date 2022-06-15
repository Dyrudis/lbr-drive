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

        $result = query("SELECT * FROM restreindre WHERE IDTag = ? AND IDUtilisateur = ?", "ii", $IDTag, $id);
        if (!$result) {
            die("Vous n'avez pas accès à ce tag en tant qu'invité");
        }
    }

    // Récupération de l'ancien nom et catégorie du tag pour les logs
    $result = query("SELECT NomTag, NomCategorie FROM tag, categorie WHERE tag.IDCategorie = categorie.IDCategorie AND IDTag = ?", "i", $IDTag);
    if ($result) {
        $row = $result[0];
        $oldName = $row['NomTag'];
        $oldCategorie = $row['NomCategorie'];
    }

    // Récupération de la nouvelle catégorie du tag pour les logs
    $result = query("SELECT NomCategorie FROM categorie WHERE IDCategorie = ?", "i", $IDCategorie);
    if ($result) {
        $row = $result[0];
        $categorie = $row['NomCategorie'];
    }

    // Vérifie si le tag modifié existe déjà
    $result = query("SELECT NomTag FROM tag WHERE NomTag = ? AND ? = tag.IDCategorie", "si", $name, $IDCategorie);
    if ($result) {
        die("Ce tag existe déjà dans cette catégorie");
    }

    // Modification du tag dans la base de données
    query("UPDATE tag SET NomTag = ?, IDCategorie = ? WHERE IDTag = ?", "ssi", $name, $IDCategorie, $IDTag);
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag modifié : " . $oldName . " → " . $name . ", " . $oldCategorie . " → " . $categorie);

die("OK");
