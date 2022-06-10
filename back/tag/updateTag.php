<?php
include("../database.php");
session_start();

$IDTag = $_POST['IDTag'];
$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

$oldName = "SELECT NomTag FROM `tag` WHERE `tag`.`IDTag` = '$IDTag'";
$oldName = $mysqli->query($oldName)->fetch_assoc()['NomTag'];

$oldCategorie = "SELECT NomCategorie FROM `categorie`, `tag` WHERE `tag`.`IDCategorie` = `categorie`.`IDCategorie` AND `tag`.`IDTag` = '$IDTag'";
$oldCategorie = $mysqli->query($oldCategorie)->fetch_assoc()['NomCategorie'];

$categorie = "SELECT NomCategorie FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$categorie = $mysqli->query($categorie)->fetch_assoc()['NomCategorie'];

$sql = "UPDATE `tag` SET `NomTag` = '$name', `IDCategorie` = '$IDCategorie' WHERE `tag`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur de modification du tag : ' . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag modifié : " . $oldName . " → " . $name . ", " . $oldCategorie . " → " . $categorie);