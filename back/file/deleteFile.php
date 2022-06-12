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

        $stmt = $mysqli->prepare("SELECT * FROM fichier WHERE IDFichier = ? AND IDUtilisateur = ?");
        $stmt->bind_param("ii", $IDFichier, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            die("Vous n'avez pas accès à ce fichier en tant qu'invité");
        }
    }

    // Récupération du nom et de l'extension du fichier pour les logs
    $stmt = $mysqli->prepare("SELECT Nom, Extension FROM fichier WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $fileName = $result['Nom'];
    $fileExtension = $result['Extension'];

    // Suppression définitive du fichier dans la base de données
    $stmt = $mysqli->prepare("DELETE FROM fichier WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// Suppression du fichier physique
$filePath = "../../upload/" . $IDFichier . "." . $fileExtension;
if (file_exists($filePath)) {
    unlink($filePath);
}

echo "Fichier supprimé";
