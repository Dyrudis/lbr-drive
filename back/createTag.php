<?php
$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

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
