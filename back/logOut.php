<?php
session_start();
$_SESSION['id']='';
echo "<p>vous avez bien été déconnecté</p>";
header("refresh:2; url=../index.php");
?>