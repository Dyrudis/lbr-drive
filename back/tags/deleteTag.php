<?php
$IDTag = $_POST['IDTag'];

// Connexion à la bdd
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Vérification des erreurs
if ($mysqli->connect_error) {
    die('Erreur lors de la connexion à la base de donnée (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Suppression du tag
$sql = "DELETE FROM `tag` WHERE `tag`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de supression du tag : ' . $mysqli->error);
}

// Suppression des liens entre tag et fichier
$sql = "DELETE FROM `classifier` WHERE `classifier`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de supression du tag des fichiers : ' . $mysqli->error);
}

// On récupère les fichiers qui n'ont plus de tag
$sql = "SELECT IDFichier FROM `fichier` WHERE IDFichier NOT IN (SELECT IDFichier from classifier)";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de récupération des fichiers sans tag : ' . $mysqli->error);
}

// On ajoute le tag '0' à tous ces fichiers
$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ";
foreach ($result->fetch_all(MYSQLI_ASSOC) as $fichier) {
    $sql .= "('" . $fichier['IDFichier'] . "', '0'),";
}
$sql = substr($sql, 0, -1);
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'ajout du tag \'Sans tag\' sur les fichiers sans tag : ' . $sql . ' -> '. $mysqli->error);
}