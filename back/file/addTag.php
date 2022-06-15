<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour ajouter un tag");
}

$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];

if ($IDTag == '0') {
    die("Vous ne pouvez pas ajouter le tag \"Sans tag\" à un fichier");
}

include("../database.php");

try {
    // Si c'est un invité on vérifie qu'il peut éditer ce fichier
    if ($_SESSION['role'] == 'invite') {
        $id = $_SESSION['id'];

        $result = query("SELECT * FROM fichier WHERE IDFichier = ? AND IDUtilisateur = ?", "ii", $IDFichier, $id);
        if (!$result) {
            die("Vous n'avez pas accès à ce fichier en tant qu'invité");
        }
    }

    // Ajout du tag dans la table classifier
    query("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, ?)", "ii", $IDFichier, $IDTag);

    // Suppresion du tag "Sans tag" du fichier (si il existe)
    query("DELETE FROM classifier WHERE IDFichier = ? AND IDTag = 0", "i", $IDFichier);

    // Récupération du nom du tag pour les logs
    $result = query("SELECT NomTag FROM tag WHERE IDTag = ?", "i", $IDTag);
    $tagName = $result[0]['NomTag'];

    // Récupération du nom du fichier pour les logs
    $result = query("SELECT Nom FROM fichier WHERE IDFichier = ?", "i", $IDFichier);
    $fileName = $result[0]['Nom'];
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Ajoute le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
