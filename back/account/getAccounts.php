<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$role = $_SESSION['role'];
if(isset($_POST['filter'])){
    $filter = $_POST['filter'];
}
else{
    $filter = false;
}
    


try{
    if($filter== true){
        $result = query("SELECT utilisateur.IDUtilisateur,utilisateur.Nom,Prenom FROM utilisateur,fichier WHERE fichier.IDUtilisateur = utilisateur.IDUtilisateur 
            AND utilisateur.IDUtilisateur != ? GROUP BY fichier.IDUtilisateur ","i",$id);
    }
    else if($role == 'admin'){
        $result = query("SELECT IDUtilisateur,Nom,Prenom,Email,Role,Description,Actif FROM utilisateur");
        
    }
    echo json_encode($result);

} catch(Exception $e){
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
