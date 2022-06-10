<?php
include("../database.php");
session_start();

$name = $_POST['name'];
$color = $_POST['color'];

// Check if the category already exists
$sql = "SELECT * FROM `categorie` WHERE NomCategorie = '" . $name . "'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    die("Cette catégorie existe déjà");
}

// Insert the data into the database
$sql = "INSERT INTO `categorie` (`IDCategorie`, `NomCategorie`, `Couleur`) VALUES (NULL, '" . $name . "', '" . $color . "');";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion de la catégorie : ' . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);