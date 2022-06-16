<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

try {
    $result = query("SELECT IDUtilisateur, Actif, MotDePasse, Role FROM utilisateur WHERE Email = ?", "s", $email);
    $id = $result[0]['IDUtilisateur'];
    $mdpHash = $result[0]['MotDePasse'];
    $role = $result[0]['Role'];
    $actif = $result[0]['Actif'];
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

if ($result && password_verify($motdepasse, $mdpHash)) {
    if ($actif == '2') {
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;

        // INSERT LOG
        registerNewLog($mysqli, $id, "Se connecte pour la première fois et modifie son mot de passe");
        echo "firstConnect";
    } else if ($actif == '1') {
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;

        // INSERT LOG
        registerNewLog($mysqli, $_SESSION['id'], "Utilisateur connecté");

        echo "connect";
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
