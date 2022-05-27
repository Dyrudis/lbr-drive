<?php
// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Get the data from the database
$sql = "SELECT `fichier`.`IDFichier`, `fichier`.`Nom` as `NomFichier`, `fichier`.`Date`, `fichier`.`Taille`, `fichier`.`Type`, `fichier`.`Extension`, `fichier`.`Duree`, `utilisateur`.`Nom`, `utilisateur`.`Prenom` FROM `fichier`, `utilisateur` WHERE `fichier`.`IDUtilisateur` = `utilisateur`.`IDUtilisateur`";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion du fichier : ' . $mysqli->error);
}

// Parse the result into an array and return it in js
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
echo json_encode($rows);
