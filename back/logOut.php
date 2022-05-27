<?php
session_start();
$_SESSION['id']='';
echo "<p>Vous avez bien été déconnecté<br><br>Redirection dans 2s</p>";
header("refresh:2; url=../index.php");
?>