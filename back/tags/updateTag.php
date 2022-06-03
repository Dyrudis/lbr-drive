<?php
$IDTag = $_POST['IDTag'];
$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sql = "UPDATE `tag` SET `NomTag` = '$name', `IDCategorie` = '$IDCategorie' WHERE `tag`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de modification du tag : ' . $mysqli->error);
}
