<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour mettre ce fichier à la corbeille");
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

    // Récupération du nom du fichier pour les logs
    $stmt = $mysqli->prepare("SELECT Nom FROM fichier WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
    $fileName = $stmt->get_result()->fetch_assoc()['Nom'];

    // Ajout de la date de mise en corbeille du fichier
    $stmt = $mysqli->prepare("UPDATE fichier SET Corbeille = CURRENT_DATE WHERE IDFichier = ?");
    $stmt->bind_param("i", $IDFichier);
    $stmt->execute();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Déplacement du fichier : \"" . $fileName . "\" dans la corbeille");

echo "OK";
