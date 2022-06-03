<?php
$IDCategorie = $_POST['IDCategorie'];
$name = $_POST['name'];
$color = $_POST['color'];

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sql = "UPDATE `categorie` SET `NomCategorie` = '$name', `Couleur` = '$color' WHERE `categorie`.`IDCategorie` = '$IDCategorie'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de modification de la catégorie : ' . $mysqli->error);
}
