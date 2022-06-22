<?php 

session_start();

//set darkMode true or false
if ($_SESSION["darkMode"] == true) {
    $_SESSION["darkMode"] = false;
    echo "theme clair";
}
else {
    $_SESSION["darkMode"] = true;
    echo "theme sombre";
}
