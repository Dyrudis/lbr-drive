<?php
include("./database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['mdpCompte'];
$emailSuppr = $_POST['emailSuppr'];

$sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($sql);



if(password_verify($mdpCompte,$result->fetch_assoc()['MotDePasse'])){
    $req = "UPDATE utilisateur SET Actif = '0' WHERE Email = '$emailSuppr'";
    $resultReq = mysqli_query($mysqli,$req);
    
    if($resultReq == TRUE){
        // INSERT LOG
        include './logRegister.php';
        registerNewLog($mysqli, $id, "Suspension du compte : " . $emailSuppr );
        
        echo"Succes";
    }
}
else{
    echo"Echec mdp";
}
