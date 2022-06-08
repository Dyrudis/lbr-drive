<?php
include("../database.php");

$IDFichier = $_POST['IDFichier'];
$NomFichier = $_POST['NomFichier'];

if ($NomFichier == "") {
    die("Erreur de modification du nom du fichier : Nom du fichier vide");
}

// Modification du nom du fichier
$sql = "UPDATE `fichier` SET `Nom` = '$NomFichier' WHERE `fichier`.`IDFichier` = '$IDFichier'";
$result = $mysqli->query($sql);

// Vérifications des erreurs
if (!$result) {
    die('Erreur de modification du nom du fichier : ' . $mysqli->error);
}

echo "OK";
