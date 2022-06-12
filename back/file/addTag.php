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

        $stmt = $mysqli->prepare("SELECT * FROM fichier WHERE IDFichier = ? AND IDUtilisateur = ?");
        $stmt->bind_param("ii", $IDFichier, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            die("Vous n'avez pas accès à ce fichier en tant qu'invité");
        }
    }

    // Ajout du tag dans la table classifier
    $stmt = $mysqli->prepare("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, ?)");
    $stmt->bind_param("ii", $IDFichier, $IDTag);
    $stmt->execute();
    $result = $stmt->get_result();

    // Suppresion du tag "Sans tag" du fichier (si il existe)
    $stmt = $mysqli->prepare("DELETE FROM classifier WHERE IDFichier = ? AND IDTag = 0");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();

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
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Ajoute le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
