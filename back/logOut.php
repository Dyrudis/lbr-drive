<?php

session_start();

// INSERT LOG
include './database.php';
include './logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Déconnexion");

$_SESSION['id']='';

header("Location:../login.php");
