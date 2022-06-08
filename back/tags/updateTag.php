<?php
include("../database.php");

$IDTag = $_POST['IDTag'];
$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

$sql = "UPDATE `tag` SET `NomTag` = '$name', `IDCategorie` = '$IDCategorie' WHERE `tag`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur de modification du tag : ' . $mysqli->error);
}
