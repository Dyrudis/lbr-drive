<?php

function registerNewLog($id, $descr) {

    /*------------------------------------*\
    |   Add all the info to the database   |
    \*------------------------------------*/

    // Connect to the database with mysqli
    $mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

    // Check for errors
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ');
    }

    // Insert the data into the database
    $sql = "INSERT INTO `log` (`IDLog`, `IDSource`, `Date`, `Description`)
    VALUES (NULL, '$id', CURRENT_DATE, '$descr')";


    $result = $mysqli->query($sql);

    //check for errors
    if (!$result) {
        die('Erreur d\'insertion du log : ' . $mysqli->error);
    }


    // Close the connection
    $mysqli->close();
}

?>