<?php

function registerNewLog($mysqli, $id, $descr)
{
    // Ajout du log dans la base de données
    $sql = $mysqli->prepare("INSERT INTO log (IDLog, IDSource, Date, Description) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?)");
    $sql->bind_param("is", $id, $descr);
    $sql->execute();
}

/* Exemple d'utilisation de la fonction registerNewLog : 

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);

*/