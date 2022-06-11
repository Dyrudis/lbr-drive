<?php

include("../database.php");

session_start();
if(!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour accéder aux catégories");
}

try {
    $stmt = $mysqli->prepare("SELECT * FROM categorie ORDER BY categorie.IDCategorie DESC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch (mysqli_sql_exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

echo json_encode($result->fetch_all(MYSQLI_ASSOC));
