<?php
// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sql = "SELECT * FROM `tag`, `categorie` WHERE tag.IDCategorie = categorie.IDCategorie";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de lecture des tags : ' . $mysqli->error);
}

echo json_encode($result->fetch_all(MYSQLI_ASSOC));