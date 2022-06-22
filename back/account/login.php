<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

try {
    //requête des informations de l'utilisateur où l'email est identique
    $result = query("SELECT IDUtilisateur, Actif, MotDePasse, Role FROM utilisateur WHERE Email = ?", "s", $email);
    $id = $result[0]['IDUtilisateur'];
    $mdpHash = $result[0]['MotDePasse'];
    $role = $result[0]['Role'];
    $actif = $result[0]['Actif'];
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

//verifie le mot de passe entré par l'utilisateur
if ($result && password_verify($motdepasse, $mdpHash)) {
    //verifie si c'est sa première connexion
    if ($actif == '2') {
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;

        // INSERT LOG
        registerNewLog($mysqli, $id, "Se connecte pour la première fois et modifie son mot de passe");
        echo "firstConnect";
    //verifie si son compte est actif 
    } else if ($actif == '1') {
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;

        // INSERT LOG
        registerNewLog($mysqli, $_SESSION['id'], "Utilisateur connecté");

        echo "connect";
    //verifie si son compte est suspendu
    } else if ($actif == '0') {
        // INSERT LOG
        registerNewLog($mysqli, $id, "Tente de se connecter mais compte suspendu");

        echo "suspendu";
    }
} else {
    // INSERT LOG
    registerNewLog($mysqli, -1, "Tentative de connexion de l'utilisateur : " . $email);

    echo "Identifiants incorrects";
}
