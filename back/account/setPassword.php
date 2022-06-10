<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$motdepasse = $_POST['nouveauMdp'];


$req = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($req);

if ($result->num_rows > 0 && $result->fetch_assoc()['Actif']=='2') {
    $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
    $sql = "UPDATE utilisateur SET MotDePasse = '$hash', Actif= '1' WHERE IDUtilisateur = '$id'";
    $result = mysqli_query($mysqli,$sql);
    echo "Succes";
}
else{
    echo "Echec";
}
?>