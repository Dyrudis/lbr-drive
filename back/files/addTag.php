<?php
include("../database.php");
session_start();

$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];

// Ajout du tag dans la table classifier
$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ('$IDFichier', '$IDTag')";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur d\'ajout du tag dans la table classifier : ' . $mysqli->error);
}

//Get the name of the new tag
$tagName = "SELECT NomTag FROM tag WHERE IDTag = '$IDTag'";
$result = $mysqli->query($tagName);

//Check for errors
if (!$result) {
    die("Erreur lors de la récupération du nom du tag pour logs : " . $mysqli->error);
}

//Get the name of the file
$fileName = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$result = $mysqli->query($fileName);

//Check for errors
if (!$result) {
    die("Erreur lors de la récupération du nom du fichier pour logs : " . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Ajoute le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
