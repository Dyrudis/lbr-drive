<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour créer un tag");
}

$name = $_POST['name'];
$IDCategorie = $_POST['IDCategorie'];

include("../database.php");

try {
    // Vérification si le tag existe déjà dans cette catégorie
    $stmt = $mysqli->prepare("SELECT * FROM tag WHERE NomTag = ? AND IDCategorie = ?");
    $stmt->bind_param("si", $name, $IDCategorie);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("Le tag \"" . $name . "\" existe déjà dans cette catégorie");
    }

    // Ajout du tag dans la base de données
    $stmt = $mysqli->prepare("INSERT INTO tag (IDTag, NomTag, IDCategorie) VALUES (NULL, ?, ?)");
    $stmt->bind_param("si", $name, $IDCategorie);
    $stmt->execute();
    $IDTag = $mysqli->insert_id;

    // Si l'utilisateur est un invité on ajoute le tag dans la liste des tags visibles par l'utilisateur
    if ($_SESSION['role'] == "invite") {
        $stmt = $mysqli->prepare("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)");
        $stmt->bind_param("ii", $_SESSION['id'], $IDTag);
        $stmt->execute();
    }
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag créé : " . $name);

die("OK");
