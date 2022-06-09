<?php

function registerNewLog($mysqli, $id, $descr) {

    /*------------------------------------*\
    |   Add all the info to the database   |
    \*------------------------------------*/


    // Insert the data into the database
    $sql = $mysqli->prepare("INSERT INTO `log` (`IDLog`, `IDSource`, `Date`, `Description`)
    VALUES (NULL, ?, CURRENT_TIMESTAMP, ?)");

    $sql->bind_param("is", $id, $descr);

    $sql->execute();
}

/*exemple of insertion for use : 

// INSERT LOG
include './logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);
*/