<?php
session_start();

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'testb');

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];
$sql = "UPDATE utilisateur SET $champ = '$valeur' WHERE email = '$email'";
$result = mysqli_query($mysqli,$sql);
echo " <p> champ changer : " . $champ . " en : " . $valeur . " pour l'utilisateur : " . $email . "</p>";
header("refresh:2; url=../compte.php");
?>