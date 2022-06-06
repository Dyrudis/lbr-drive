<?php
$IDFichier = $_POST['IDFichier'];
$NomFichier = $_POST['NomFichier'];

if ($NomFichier == "") {
    die("Erreur de modification du nom du fichier : Nom du fichier vide");
}

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Modification du nom du fichier
$sql = "UPDATE `fichier` SET `Nom` = '$NomFichier' WHERE `fichier`.`IDFichier` = '$IDFichier'";
$result = $mysqli->query($sql);

// Vérifications des erreurs
if (!$result) {
    die('Erreur de modification du nom du fichier : ' . $mysqli->error);
}

echo "OK";
