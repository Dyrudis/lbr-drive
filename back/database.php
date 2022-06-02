<?php

/* CE FICHIER N'EST PAS ENCORE UTILISÉ */

// Récupération des authentifiants de connexion
include('../env.php');

// Connexion à la bdd
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
