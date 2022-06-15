<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour créer un tag");
}

$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

include("../database.php");

try {
    // Vérification si le tag existe déjà dans cette catégorie
    $result = query("SELECT * FROM tag WHERE NomTag = ? AND IDCategorie = ?", "si", $name, $IDCategorie);
    if ($result) {
        die("Le tag \"" . $name . "\" existe déjà dans cette catégorie");
    }

    // Ajout du tag dans la base de données
    query("INSERT INTO tag (NomTag, IDCategorie) VALUES (?, ?)", "si", $name, $IDCategorie);
    $IDTag = $mysqli->insert_id;

    // Si l'utilisateur est un invité on ajoute le tag dans la liste des tags visibles par l'utilisateur
    if ($_SESSION['role'] == "invite") {
        query("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)", "ii", $_SESSION['id'], $IDTag);
    }
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag créé : " . $name);

die("OK");
