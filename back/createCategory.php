<?php

$name = $_POST['name'];
$color = $_POST['color'];

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Check if the category already exists
$sql = "SELECT * FROM `categorie` WHERE NomCategorie = '" . $name . "'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    die("Cette catégorie existe déjà");
}

// Insert the data into the database
$sql = "INSERT INTO `categorie` (`IDCategorie`, `NomCategorie`, `CouleurCategorie`) VALUES (NULL, '" . $name . "', '" . $color . "');";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion de la catégorie : ' . $mysqli->error);
}
