<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$mdpCompte = $_POST['mdpCompte'];
$email = $_POST['email'];

$sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($sql);



if(password_verify($mdpCompte,$result->fetch_assoc()['MotDePasse'])){
    $req = "UPDATE utilisateur SET Actif = '0' WHERE Email = '$email'";
    $resultReq = mysqli_query($mysqli,$req);
    echo"<p>Compte bien supprimé<br><br>Redirection dans 2s</p>";
    header("refresh:2; url=../compte.php");
}
else{
    echo"<p>Mot de passe incorrect<br><br>Redirection dans 2s</p>";
    header("refresh:2; url=../compte.php");
}

?>