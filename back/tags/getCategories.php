<?php
include("../database.php");

$sql = "SELECT * FROM `categorie` ORDER BY `categorie`.`IDCategorie` DESC";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de lecture des catégories : ' . $mysqli->error);
}

echo json_encode($result->fetch_all(MYSQLI_ASSOC));
