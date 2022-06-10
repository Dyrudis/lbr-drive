<?php

session_start();

// INSERT LOG
include '../database.php';
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Déconnexion");

$_SESSION['id']='';

header("Location:../../login.php");
