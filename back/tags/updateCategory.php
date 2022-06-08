<?php
include("../database.php");

$IDCategorie = $_POST['IDCategorie'];
$name = $_POST['name'];
$color = $_POST['color'];

$sql = "UPDATE `categorie` SET `NomCategorie` = '$name', `Couleur` = '$color' WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de modification de la catégorie : ' . $mysqli->error);
}
