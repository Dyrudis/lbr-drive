<?php 

session_start();

if ($_SESSION["darkMode"] == true) {
    $_SESSION["darkMode"] = false;
    echo "theme clair";
}
else {
    $_SESSION["darkMode"] = true;
    echo "theme sombre";
}
