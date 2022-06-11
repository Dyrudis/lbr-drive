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
    $stmt = $mysqli->prepare("SELECT * FROM categorie WHERE NomCategorie = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("La catégorie \"" . $name . "\" existe déjà");
    }

    // Ajout de la catégorie dans la base de données
    $stmt = $mysqli->prepare("INSERT INTO categorie (IDCategorie, NomCategorie, Couleur) VALUES (NULL, ?, ?)");
    $stmt->bind_param("ss", $name, $color);
    $stmt->execute();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);

die("OK");
