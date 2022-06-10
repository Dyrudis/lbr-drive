<?php
include("../database.php");
session_start();

if (!isset($_POST['IDFichier'])) {
    die("Aucun fichier à supprimer envoyé");
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
    die("Vous n'avez pas les droits pour supprimer ce fichier : ". $sql);
}

// Delete the file
$sql = "DELETE FROM fichier WHERE IDFichier = '$IDFichier'";

$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die("Erreur lors de la suppression du fichier : " . $mysqli->error);
}

echo "Fichier supprimé";
