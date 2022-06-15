<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour modifier un titre");
}

$IDFichier = $_POST['IDFichier'];
$NomFichier = $_POST['NomFichier'];

if (preg_match('/^\s*$/', $NomFichier)) {
    die("Vous ne pouvez pas mettre un titre vide");
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

    // Récupération de l'ancien nom du fichier pour les logs
    $result = query("SELECT Nom FROM fichier WHERE IDFichier = ?", "i", $IDFichier);
    $oldName = $result[0]['Nom'];

    // Modification du nom du fichier
    query("UPDATE fichier SET Nom = ? WHERE IDFichier = ?", "si", $NomFichier, $IDFichier);
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Modifie le nom du fichier : " . $oldName . " → " . $NomFichier);

echo "OK";
