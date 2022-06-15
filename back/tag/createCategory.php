<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour créer une catégorie");
}

$name = $_POST['name'];
$color = $_POST['color'];

include("../database.php");

try {
    // Vérification si la catégorie existe déjà
    $result = query("SELECT * FROM categorie WHERE NomCategorie = ?", "s", $name);
    if ($result) {
        die("La catégorie \"" . $name . "\" existe déjà");
    }

    // Ajout de la catégorie dans la base de données
    query("INSERT INTO categorie (NomCategorie, Couleur) VALUES (?, ?)", "ss", $name, $color);
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);

die("OK");
