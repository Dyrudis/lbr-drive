<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];


$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);
foreach($result as $info){
    $id = $info['IDUtilisateur'];
    $actif = $info['Actif'];
    $mdpHash = $info['MotDePasse'];
    $role = $info['Role'];
}

if ($result->num_rows > 0 && password_verify($motdepasse,$mdpHash)) {
    if($actif=='2'){
        $_SESSION['id'] = $id;

        // INSERT LOG
        registerNewLog($mysqli, $id, "Se connecte pour la première fois et modifie son mot de passe");
        echo"firstConnect";
    }
    else if($actif=='1'){
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;

        // INSERT LOG
        registerNewLog($mysqli, $_SESSION['id'], "Utilisateur connecté");

        echo"connect";
    }
    else if($actif=='0'){
        // INSERT LOG
        registerNewLog($mysqli, $id, "Tente de se connecter mais compte suspendu");

        echo"suspendu";
    }
}else {
    // INSERT LOG
    registerNewLog($mysqli, -1, "Tentative de connexion de l'utilisateur : " . $email);
    
    echo"Identifiants incorrects";
    header("refresh:2, url=../login.php");

}

