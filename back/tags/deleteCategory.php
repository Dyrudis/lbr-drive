<?php
include("../database.php");
session_start();

$IDCategorie = $_POST['IDCategorie'];

// Change la catégorie des tags associés par Autres
$sql = "UPDATE `tag` SET `IDCategorie` = '0' WHERE `tag`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de déplacement des tags : ' . $mysqli->error);
}

//Stock the name of the category
$name = "SELECT NomCategorie FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$name = $mysqli->query($name)->fetch_assoc()['NomCategorie'];


// Delete the category
$sql = "DELETE FROM `categorie` WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de supression de la catégorie : ' . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie supprimée : " . $name);
