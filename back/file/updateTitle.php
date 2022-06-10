<?php
include("../database.php");
session_start();

$IDFichier = $_POST['IDFichier'];
$NomFichier = $_POST['NomFichier'];

if ($NomFichier == "") {
    die("Erreur de modification du nom du fichier : Nom du fichier vide");
}

//Get the name of the file
$oldName = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$oldName = $mysqli->query($oldName)->fetch_assoc()['Nom'];

//Check for errors
if (!$oldName) {
    die("Erreur lors de la récupération du nom pour logs : " . $mysqli->error);
}

// Modification du nom du fichier
$sql = "UPDATE `fichier` SET `Nom` = '$NomFichier' WHERE `fichier`.`IDFichier` = '$IDFichier'";
$result = $mysqli->query($sql);

// Vérifications des erreurs
if (!$result) {
    die('Erreur de modification du nom du fichier : ' . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Modifie le nom du fichier : " . $oldName . " → " . $NomFichier);

echo "OK";
