<?php

include("../database.php");

session_start();
if(!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder aux catégories");
}

try {
    $result = query("SELECT * FROM categorie ORDER BY categorie.IDCategorie DESC");
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

echo json_encode($result);
