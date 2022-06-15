<?php

include("../database.php");

session_start();
if (!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder aux tags");
}

$id = $_SESSION['id'];
$role = $_SESSION['role'];

try {
    // Restriction des tags visibles si l'utilisateur est un invité
    if ($role == 'invite') {
        $result = query("SELECT * FROM tag, categorie, restreindre WHERE tag.IDCategorie = categorie.IDCategorie AND
        restreindre.IDTag = tag.IDTag AND restreindre.IDUtilisateur = ? ORDER BY categorie.IDCategorie DESC, tag.NomTag ASC", "i", $id);
    } else {
        $result = query("SELECT * FROM tag, categorie WHERE tag.IDCategorie = categorie.IDCategorie ORDER BY categorie.IDCategorie DESC, tag.NomTag ASC");
    }
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

echo json_encode($result);
