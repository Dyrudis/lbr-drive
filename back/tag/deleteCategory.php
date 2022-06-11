<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer cette catégorie");
}

$IDCategorie = $_POST['IDCategorie'];

include("../database.php");

try {
    // Récupération du nom de la catégorie pour les logs
    $stmt = $mysqli->prepare("SELECT NomCategorie FROM categorie WHERE categorie.IDCategorie = ?");
    $stmt->bind_param("i", $IDCategorie);
    $stmt->execute();
    $name = $stmt->get_result()->fetch_assoc()['NomCategorie'];

    // Suppression de la catégorie dans la base de données
    $stmt = $mysqli->prepare("DELETE FROM categorie WHERE categorie.IDCategorie = ?");
    $stmt->bind_param("i", $IDCategorie);
    $stmt->execute();

    // Change la catégorie des tags associés par Autres
    $stmt = $mysqli->prepare("UPDATE tag SET IDCategorie = '0' WHERE tag.IDCategorie = ?");
    $stmt->bind_param("i", $IDCategorie);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie supprimée : " . $name);

die("OK");
