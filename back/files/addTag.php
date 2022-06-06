<?php
$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Ajout du tag dans la table classifier
$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ('$IDFichier', '$IDTag')";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur d\'ajout du tag dans la table classifier : ' . $mysqli->error);
}

echo "OK";
