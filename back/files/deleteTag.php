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

// Suppression du lien entre le fichier et le tag
$sql = "DELETE FROM `classifier` WHERE `classifier`.`IDFichier` = '$IDFichier' AND `classifier`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur de supression du tag d\'un fichier : ' . $mysqli->error);
}

// On récupère les tags de ce fichier
$sql = "SELECT IDFichier FROM `classifier` WHERE `classifier`.`IDFichier` = '$IDFichier'";
$result = $mysqli->query($sql);

// Vérification des erreurs
if (!$result) {
    die('Erreur de la récupération des tag d\'un fichier : ' . $mysqli->error);
}

// Si le fichier n'a plus de tag, on ajoute le tag '0'
if ($result->num_rows == 0) {
    $sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ('$IDFichier', '0')";
    $result = $mysqli->query($sql);

    // Vérification des erreurs
    if (!$result) {
        die('Erreur d\'ajout du tag \'Sans tag\' sur un fichier sans tag : ' . $mysqli->error);
    }
}

echo "OK";
