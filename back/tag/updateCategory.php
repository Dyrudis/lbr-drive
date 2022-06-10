<?php
include("../database.php");
session_start();

$IDCategorie = $_POST['IDCategorie'];
$name = $_POST['name'];
$color = $_POST['color'];

$oldName = "SELECT NomCategorie FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$oldName = $mysqli->query($oldName)->fetch_assoc()['NomCategorie'];

$oldColor = "SELECT Couleur FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$oldColor = $mysqli->query($oldColor)->fetch_assoc()['Couleur'];

$sql = "UPDATE `categorie` SET `NomCategorie` = '$name', `Couleur` = '$color' WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de modification de la catégorie : ' . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie modifiée : " . $oldName . " → " . $name . ", #" . $oldColor . " → #" . $color);