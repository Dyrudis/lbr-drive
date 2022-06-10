<?php
include("../database.php");
session_start();

$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

// Check if the tag already exists
$sql = "SELECT * FROM `tag` WHERE NomTag = '" . $name . "'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    die("Ce tag existe déjà");
}

// Insert the data into the database
$sql = "INSERT INTO `tag` (`IDTag`, `NomTag`, `IDCategorie`) VALUES (NULL, '" . $name . "', '" . $IDCategorie . "');";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion de la catégorie : ' . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag créé : " . $name);