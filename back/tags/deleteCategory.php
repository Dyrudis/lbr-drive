<?php
include("../database.php");

$IDCategorie = $_POST['IDCategorie'];

// Change the category of all tags with the IDCategorie
$sql = "UPDATE `tag` SET `IDCategorie` = '0' WHERE `tag`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de déplacement des tags : ' . $mysqli->error);
}

// Delete the category
$sql = "DELETE FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de supression de la catégorie : ' . $mysqli->error);
}
