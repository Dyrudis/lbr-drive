<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$motdepasse = $_POST['nouveauMdp'];

try{
    //requête pour récupérer les info de l'utilisateur connecté
    $result = query("SELECT * FROM utilisateur WHERE IDUtilisateur = ?", "i", $id);

    //vérifie que l'utilisateur à son actif a 2
    if ($result && $result[0]['Actif']=='2') {
        $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
        //update le mot de passe de l'utilisateur
        query("UPDATE utilisateur SET MotDePasse = ?, Actif= '1' WHERE IDUtilisateur = ?", "si", $hash, $id);
        echo "Succes";
    }
    else{
        echo "Echec";
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
?>