<?php
include("../database.php");
session_start();

if (!isset($_POST['IDFichier'])) {
    die("Aucun fichier à suspendre envoyé");
}

$IDFichier = json_decode($_POST['IDFichier']);

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    die("Vous n'êtes pas connecté");
}


// Get the id of the user who posted the file
$sql = "SELECT IDUtilisateur FROM fichier WHERE IDFichier = '$IDFichier' AND IDUtilisateur = '$_SESSION[id]'";
$result = $mysqli->query($sql);

// Get the name of the file
$fileName = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$fileName = $mysqli->query($fileName)->fetch_assoc()['Nom'];

// Check for errors
if (!$result) {
    die("Erreur lors de la vérification des authorisations" . $mysqli->error);
}

// Check for the autorization
if ($result->num_rows == 0 && $_SESSION['role'] != 'admin' && $_SESSION['role'] != 'ecriture') {
    die("Vous n'avez pas les droits pour suspendre ce fichier : " . $sql);
}

// Add current date to the file
$sql = "UPDATE fichier SET Corbeille = CURRENT_DATE WHERE IDFichier = '$IDFichier'";

$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die("Erreur lors de la suspension du fichier : " . $mysqli->error);
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Déplacement du fichier : \"" . $fileName . "\" dans la corbeille");

echo "OK";
