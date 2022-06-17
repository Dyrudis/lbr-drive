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
    $result = query("SELECT NomTag FROM tag WHERE IDTag = ?", "i", $IDTag);
    $tagName = $result[0]['NomTag'];

    // Récupération du nom du fichier pour les logs
    $result = query("SELECT Nom FROM fichier WHERE IDFichier = ?", "s", $IDFichier);
    $fileName = $result[0]['Nom'];

    // Suppression du lien entre le fichier et le tag
    query("DELETE FROM classifier WHERE IDFichier = ? AND IDTag = ?", "si", $IDFichier, $IDTag);

    // On récupère les tags de ce fichier
    $result = query("SELECT IDTag FROM classifier WHERE IDFichier = ?", "s", $IDFichier);

    // Si le fichier n'a plus de tag, on ajoute le tag "Sans tag"
    if (!$result) {
        query("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, 0)", "s", $IDFichier);
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Retire le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
