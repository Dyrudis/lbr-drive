<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer cette catégorie");
}

$IDCategorie = $_POST['IDCategorie'];

if ($IDCategorie == '0') {
    die("Vous ne pouvez pas supprimer la catégorie \"Autres\"");
}

include("../database.php");

try {
    // Récupération du nom de la catégorie pour les logs
    $result = query("SELECT NomCategorie FROM categorie WHERE IDCategorie = ?", "i", $IDCategorie);
    $name = $result[0]['NomCategorie'];

    // Suppression de la catégorie dans la base de données
    query("DELETE FROM categorie WHERE IDCategorie = ?", "i", $IDCategorie);

    // Change la catégorie des tags associés par Autres
    query("UPDATE tag SET IDCategorie = '0' WHERE IDCategorie = ?", "i", $IDCategorie);
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie supprimée : " . $name);

die("OK");
