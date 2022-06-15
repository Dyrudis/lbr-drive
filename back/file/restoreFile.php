<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour enlever ce fichier à la corbeille");
}

$IDFichier = $_POST['IDFichier'];

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

    // Récupération du nom du fichier pour les logs
    $result = query("SELECT Nom FROM fichier WHERE IDFichier = ?", "i", $IDFichier);
    $fileName = $result[0]['Nom'];

    // Suppression de la date de mise en corbeille du fichier
    query("UPDATE fichier SET Corbeille = NULL WHERE IDFichier = ?", "i", $IDFichier);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Restaure le fichier : " . $fileName);

echo "OK";
