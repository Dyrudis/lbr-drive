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

if ($IDCategorie == '0') {
    die("Vous ne pouvez pas modifier la catégorie \"Autres\"");
}

include("../database.php");

try {
    // Récupération de l'ancien nom et couleur de la catégorie pour les logs
    $result = query("SELECT NomCategorie, Couleur FROM categorie WHERE IDCategorie = ?", "i", $IDCategorie);
    if ($result) {
        $oldName = $result[0]['NomCategorie'];
        $oldColor = $result[0]['Couleur'];
    }

    // Vérifie si la categorie modifiée existe déjà
    $result = query("SELECT IDCategorie, Couleur FROM categorie WHERE NomCategorie = ?", "s", $name);
    if ($result) {
        if ($result[0]['IDCategorie'] != $IDCategorie) {
            die("Cette catégorie existe déjà");
        }
        else if ($result[0]['Couleur'] == $color) {
            die ("Modification nulle");
        }
    }
    


    // Modification de la catégorie dans la base de données
    query("UPDATE categorie SET NomCategorie = ?, Couleur = ? WHERE IDCategorie = ?", "ssi", $name, $color, $IDCategorie);
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie modifiée : " . $oldName . " → " . $name . ", #" . $oldColor . " → #" . $color);

die("OK");
