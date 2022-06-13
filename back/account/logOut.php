<?php

session_start();

// INSERT LOG
include '../database.php';
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Déconnexion");

session_destroy();

header("Location:../../login.php");
