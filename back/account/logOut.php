<?php

session_start();

// INSERT LOG
include '../database.php';
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Déconnexion");

unset($_SESSION['id']);
unset($_SESSION['role']);

header("Location:../../login.php");
