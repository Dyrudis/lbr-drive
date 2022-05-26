<?php
session_start();
$_SESSION['id']='';
echo "<p>vous avez bien été déconnecté<br><br>Rediection dans 2s</p>";
header("refresh:2; url=../index.php");
?>