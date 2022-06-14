<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpAdmin = $_POST['mdpCompte'];
$emailSuppr = $_POST['emailSuppr'];

//requete au serveur pour recuperer le mdp du compte admin
try{
    $stmt = $mysqli->prepare("SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($mdpHash);
    $stmt->fetch();



//test le mot de passe de l'admin 
    if(password_verify($mdpAdmin,$mdpHash)){
        //requete pour actualiser l'actif du compte a supprimer a 0
        $stmt = $mysqli->prepare("UPDATE utilisateur SET Actif = '0' WHERE Email = ?");
        $stmt->bind_param("s", $emailSuppr);
        $stmt->execute();
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
