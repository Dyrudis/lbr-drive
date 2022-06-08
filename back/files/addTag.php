<?php
include("../database.php");

$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];

// Ajout du tag dans la table classifier
$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ('$IDFichier', '$IDTag')";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur d\'ajout du tag dans la table classifier : ' . $mysqli->error);
}

echo "OK";
