<?php

session_start();

// INSERT LOG
include './database.php';
include './logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Déconnexion");

$_SESSION['id']='';

echo "<p>Vous avez bien été déconnecté<br><br>Redirection dans 2s</p>";
header("refresh:2; url=../index.php");
