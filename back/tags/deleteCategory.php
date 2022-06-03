<?php
$IDCategorie = $_POST['IDCategorie'];

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

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
