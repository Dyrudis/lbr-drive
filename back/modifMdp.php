<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['ancienMdp'];
$newMdp = $_POST['NewMdp'];

$req = "SELECT MotDePasse FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($req);


if(password_verify($mdpCompte,$result->fetch_assoc()['MotDePasse'])){
    $hash = password_hash($newMdp,PASSWORD_DEFAULT);
    $req = "UPDATE utilisateur SET MotDePasse = '$hash' WHERE IDUtilisateur = '$id'";
    $resultReq = mysqli_query($mysqli,$req);
    echo"<p>Mot de passe bien modifier<br><br>Redirection dans 2s</p>";
    header("refresh:2; url=../compte.php");
}
else{
    echo"<p>Mot de passe incorrect<br><br>Redirection dans 2s</p>";
    header("refresh:2; url=../compte.php");
}

?>