<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['ancienMdp'];
$newMdp = $_POST['nouveauMdp'];

$req = "SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($req);

try{   
    if (password_verify($mdpCompte, $result->fetch_assoc()['MotDePasse'])) {
        $hash = password_hash($newMdp, PASSWORD_DEFAULT);
        query("UPDATE utilisateur SET MotDePasse = '$hash' WHERE IDUtilisateur = ?", "i", $id);
        
        // INSERT LOG
        include '../log/registerLog.php';
        registerNewLog($mysqli, $id, "Modifie son mot de passe");

        echo "Succes";
    } else {
        echo "Echec";
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}