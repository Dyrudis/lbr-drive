<?php
session_start();
// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

//récupération du role et de l'id du compte actuellement connecté
$role = $_SESSION['role'];
$id = $_SESSION['id'];

// Regarde si le compte est invité afin de restreindre les tags visible
if($role == 'invite'){
    $sql = "SELECT * FROM tag, categorie,restreindre WHERE tag.IDCategorie = categorie.IDCategorie AND restreindre.IDTag = tag.IDTag AND restreindre.IDUtilisateur = $id";
    $result = $mysqli->query($sql);

    // Check for errors
    if (!$result) {
        die('Erreur de lecture des tags : ' . $mysqli->error);
    }
}
else{
    $sql = "SELECT * FROM `tag`, `categorie` WHERE tag.IDCategorie = categorie.IDCategorie";
    $result = $mysqli->query($sql);

    // Check for errors
    if (!$result) {
        die('Erreur de lecture des tags : ' . $mysqli->error);
    }
}


echo json_encode($result->fetch_all(MYSQLI_ASSOC));
