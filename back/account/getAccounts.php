<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];

//vérification des droits 
$authorized = ['admin'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour suspendre un compte");
}


try{
    $result = query("SELECT * FROM utilisateur");
    echo json_encode($result);

} catch(Exception $e){
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
