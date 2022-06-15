<?php

function registerNewLog($mysqli, $id, $descr)
{
    // Ajout du log dans la base de données
    query("INSERT INTO log (IDSource, Date, Description) VALUES (?, CURRENT_TIMESTAMP, ?)", "is", $id, $descr);
}

/* Exemple d'utilisation de la fonction registerNewLog : 

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Catégorie créée : " . $name);

*/