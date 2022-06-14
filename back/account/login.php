<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

try {
    $stmt = $mysqli->prepare("SELECT IDUtilisateur, Actif, MotDePasse, Role FROM utilisateur WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $actif, $mdpHash, $role);
    $stmt->fetch();
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

if ($stmt->num_rows > 0 && password_verify($motdepasse, $mdpHash)) {
    if ($actif == '2') {
        $_SESSION['id'] = $id;

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
