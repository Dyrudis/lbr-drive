<?php
session_start();

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

$id = $_SESSION['id'];
$mdpCompte = $_POST['mdpCompte'];
$email = $_POST['email'];

$sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($sql);



if($result->fetch_assoc()['MotDePasse']==$mdpCompte){
    $req = "UPDATE utilisateur SET Actif = '0' WHERE Email = '$email'";
    $resultReq = mysqli_query($mysqli,$req);
    echo"<p> compte bien supprimer </p>";
    header("refresh:2; url=../compte.php");
}
else{
    echo"<p> mot de passe incorrect</p>";
    header("refresh:2; url=../compte.php");
}

?>