<?php
include("./database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['ancienMdp'];
$newMdp = $_POST['nouveauMdp'];

$req = "SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($req);


if (password_verify($mdpCompte, $result->fetch_assoc()['MotDePasse'])) {
    $hash = password_hash($newMdp, PASSWORD_DEFAULT);
    $req = "UPDATE utilisateur SET MotDePasse = '$hash' WHERE IDUtilisateur = '$id'";
    $resultReq = mysqli_query($mysqli, $req);
    
    // INSERT LOG
    include './logRegister.php';
    registerNewLog($mysqli, $id, "Modifie son mot de passe");

    echo "Succes";
} else {
    echo "Echec";
}
