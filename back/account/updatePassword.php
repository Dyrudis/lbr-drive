<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['ancienMdp'];
$newMdp = $_POST['nouveauMdp'];

try{   
    //requete du mot de passe du compte actuellement connecté
    $result = query("SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = ?", "i", $id);

    //verifie le mot de passe entré
    if (password_verify($mdpCompte, $result['0']['MotDePasse'])) {
        $hash = password_hash($newMdp, PASSWORD_DEFAULT);
        //upadate mdp
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