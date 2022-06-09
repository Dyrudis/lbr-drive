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
$tagName = $mysqli->query($tagName)->fetch_assoc()['NomTag'];

//Check for errors
if (!$tagName) {
    die("Erreur lors de la récupération du nom du tag pour logs : " . $mysqli->error);
}

//Get the name of the file
$fileName = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$fileName = $mysqli->query($fileName)->fetch_assoc()['Nom'];

//Check for errors
if (!$fileName) {
    die("Erreur lors de la récupération du nom du fichier pour logs : " . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Ajoute le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
