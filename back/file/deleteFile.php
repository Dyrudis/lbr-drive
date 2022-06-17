<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer définitivement ce fichier");
}

$IDFichier = $_POST['IDFichier'];

include("../database.php");

try {
    // Si c'est un invité on vérifie qu'il peut éditer ce fichier
    if ($_SESSION['role'] == 'invite') {
        $id = $_SESSION['id'];

        $result = query("SELECT * FROM fichier WHERE IDFichier = ? AND IDUtilisateur = ?", "si", $IDFichier, $id);
        if (!$result) {
            die("Vous n'avez pas accès à ce fichier en tant qu'invité");
        }
    }

    // Récupération du nom et de l'extension du fichier pour les logs
    $result = query("SELECT Nom, Extension FROM fichier WHERE IDFichier = ?", "s", $IDFichier);
    $fileName = $result[0]['Nom'];
    $fileExtension = $result[0]['Extension'];

    // Suppression définitive du fichier dans la base de données
    query("DELETE FROM fichier WHERE IDFichier = ?", "s", $IDFichier);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// Suppression du fichier physique
$filePath = "../../upload/" . $IDFichier . "." . $fileExtension;
if (file_exists($filePath)) {
    unlink($filePath);
}

echo "Fichier supprimé";
