<?php
session_start();

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'testb');

$id = $_SESSION['id'];
$mdpCompte = $_POST['mdpCompte'];
$email = $_POST['email'];

$sql = "SELECT * FROM utilisateur WHERE idUtilisateur = '$id'";
$result = $mysqli->query($sql);



if($result->fetch_assoc()['motdepasse']==$mdpCompte){
    $req = "UPDATE utilisateur SET email = ' ' WHERE email = '$email'";
    $resultReq = mysqli_query($mysqli,$req);
    echo"<p> compte bien supprimer </p>";
    header("refresh:2; url=../compte.php");
}
else{
    echo"<p> mot de passe incorrect</p>";
    header("refresh:2; url=../compte.php");
}

?>