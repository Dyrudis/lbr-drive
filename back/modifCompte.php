<?php
include("./database.php");
session_start();

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];
$sql = "UPDATE utilisateur SET $champ = '$valeur' WHERE Email = '$email'";
$result = mysqli_query($mysqli,$sql);
echo " <p>Champ changé : " . $champ . " en : " . $valeur . " pour l'utilisateur : " . $email . "<br><br>Redirection dans 2s</p>";
header("refresh:2; url=../compte.php");
?>