<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour supprimer ce tag");
}

$IDTag = $_POST['IDTag'];

if ($IDTag == '0') {
    die("Vous ne pouvez pas supprimer le tag \"Sans tag\"");
}

include("../database.php");

try {
    // Si c'est un invité on vérifie qu'il a accès au tag
    if ($_SESSION['role'] == 'invite') {
        $id = $_SESSION['id'];

        $result = query("SELECT * FROM restreindre WHERE IDTag = ? AND IDUtilisateur = ?", "ii", $IDTag, $id);
        if (!$result) {
            die("Vous n'avez pas accès à ce tag en tant qu'invité");
        }
    }

    // Récupération du nom du tag pour les logs
    $result = query("SELECT NomTag FROM tag WHERE IDTag = ?", "i", $IDTag);
    $name = $result[0]['NomTag'];

    // Suppression du tag dans la base de données
    query("DELETE FROM tag WHERE tag.IDTag = ?", "i", $IDTag);

    // Suppression des liens entre tag et fichier
    query("DELETE FROM classifier WHERE classifier.IDTag = ?", "i", $IDTag);

    // Récupèration des fichiers qui n'ont plus de tag
    $filesWithoutTag = query("SELECT IDFichier FROM fichier WHERE IDFichier NOT IN (SELECT IDFichier from classifier)");

    // On ajoute le tag '0' à tous ces fichiers
    foreach ($filesWithoutTag as $file) {
        $IDFichier = $file['IDFichier'];
        query("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, '0')", "i", $IDFichier);
    }
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag supprimé : " . $name);

die("OK");
