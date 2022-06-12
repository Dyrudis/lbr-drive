<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer un tag");
}

$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];

if ($IDTag == '0') {
    die("Vous ne pouvez pas supprimer le tag \"Sans tag\" d'un fichier");
}

include("../database.php");

try {
    // Récupération du nom du tag pour les logs
    $stmt = $mysqli->prepare("SELECT NomTag FROM tag WHERE IDTag = ?");
    $stmt->bind_param("i", $IDTag);
    $stmt->execute();
    $tagName = $stmt->get_result()->fetch_assoc()['NomTag'];

    // Récupération du nom du fichier pour les logs
    $stmt = $mysqli->prepare("SELECT Nom FROM fichier WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
    $fileName = $stmt->get_result()->fetch_assoc()['Nom'];

    // Suppression du lien entre le fichier et le tag
    $stmt = $mysqli->prepare("DELETE FROM classifier WHERE IDFichier = ? AND IDTag = ?");
    $stmt->bind_param("ii", $IDFichier, $IDTag);
    $stmt->execute();

    // On récupère les tags de ce fichier
    $stmt = $mysqli->prepare("SELECT IDTag FROM classifier WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si le fichier n'a plus de tag, on ajoute le tag "Sans tag"
    if ($result->num_rows == 0) {
        $stmt = $mysqli->prepare("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, 0)");
        $stmt->bind_param("i", $IDFichier);
        $stmt->execute();
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Retire le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
