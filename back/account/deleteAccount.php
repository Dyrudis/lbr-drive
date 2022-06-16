<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpAdmin = $_POST['mdpCompte'];
$emailSuppr = $_POST['emailSuppr'];

//vérification des droits 
$authorized = ['admin'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour suspendre un compte");
}


try{
    //requete au serveur pour recuperer le mdp du compte admin
    $result = query("SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = ?", "i", $id);


    //test le mot de passe de l'admin 
    if(password_verify($mdpAdmin,$result[0]['MotDePasse'])){
        //requete pour actualiser l'actif du compte a supprimer a 0
        query("UPDATE utilisateur SET Actif = '0' WHERE Email = ?", "s", $emailSuppr);
        echo"Succes";

        // INSERT LOG
        include '../log/registerLog.php';
        registerNewLog($mysqli, $id, "Suspension du compte : " . $emailSuppr );

    }
    else{
        echo"Echec mdp";
    }
} catch(Exception $e){
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
