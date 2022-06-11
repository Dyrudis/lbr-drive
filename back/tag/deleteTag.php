<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer ce tag");
}

$IDTag = $_POST['IDTag'];

include("../database.php");

try {
    // Si c'est un invité on vérifie qu'il a accès au tag
    if ($_SESSION['role'] == 'invite') {
        $id = $_SESSION['id'];

        $stmt = $mysqli->prepare("SELECT * FROM restreindre WHERE IDTag = ? AND IDUtilisateur = ?");
        $stmt->bind_param("ii", $IDTag, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            die("Vous n'avez pas accès à ce tag en tant qu'invité");
        }
    }

    // Récupération du nom du tag pour les logs
    $stmt = $mysqli->prepare("SELECT NomTag FROM tag WHERE IDTag = ?");
    $stmt->bind_param("i", $IDTag);
    $stmt->execute();
    $name = $stmt->get_result()->fetch_assoc()['NomTag'];

    // Suppression du tag dans la base de données
    $stmt = $mysqli->prepare("DELETE FROM tag WHERE tag.IDTag = ?");
    $stmt->bind_param("i", $IDTag);
    $stmt->execute();

    // Suppression des liens entre tag et fichier
    $stmt = $mysqli->prepare("DELETE FROM classifier WHERE classifier.IDTag = ?");
    $stmt->bind_param("i", $IDTag);
    $stmt->execute();

    // Récupèration des fichiers qui n'ont plus de tag
    $stmt = $mysqli->prepare("SELECT IDFichier FROM fichier WHERE IDFichier NOT IN (SELECT IDFichier from classifier)");
    $stmt->execute();
    $filesWithoutTag = $stmt->get_result();

    // On ajoute le tag '0' à tous ces fichiers
    $stmt = $mysqli->prepare("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, '0')");
    $stmt->bind_param("i", $IDFichier);
    foreach ($filesWithoutTag->fetch_all(MYSQLI_ASSOC) as $file) {
        $IDFichier = $file['IDFichier'];
        $stmt->execute();
    }
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag supprimé : " . $name);

die("OK");
