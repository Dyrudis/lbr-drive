<?php
include("../database.php");
session_start();

if (!isset($_POST['IDFichier'])) {
    die("Aucun fichier à restaurer envoyé");
}

$IDFichier = json_decode($_POST['IDFichier']);

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    die("Vous n'êtes pas connecté");
}

// Get the id of the user who posted the file
$sql = "SELECT IDUtilisateur FROM fichier WHERE IDFichier = '$IDFichier' AND IDUtilisateur = '$_SESSION[id]'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die("Erreur lors de la vérification des authorisations" . $mysqli->error);
}

// Check for the autorization
if ($result->num_rows == 0 && $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'ecriture') {
    die("Vous n'avez pas les droits pour restaurer ce fichier : ". $sql);
}

// Remove date to the file
$sql = "UPDATE fichier SET Corbeille = NULL WHERE IDFichier = '$IDFichier'";

$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die("Erreur lors de la restauration du fichier : " . $mysqli->error);
}

// Get the name of the file
$name = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$name = $mysqli->query($name)->fetch_assoc()['Nom'];

//Check for errors
if (!$name) {
    die("Erreur lors de la récupération du nom pour logs : " . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Restaure le fichier : " . $name);

echo "OK";
