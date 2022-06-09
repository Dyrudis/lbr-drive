<?php
include("../database.php");
session_start();

$IDTag = $_POST['IDTag'];

//Get tag name
$tagName = "SELECT NomTag FROM tag WHERE IDTag = '$IDTag'";
$tagName = $mysqli->query($tagName)->fetch_assoc()['NomTag'];

//check for errors
if (!$tagName) {
    die("Erreur lors de la récupération nom tag pour logs : " . $mysqli->error);
}

// Suppression du tag
$sql = "DELETE FROM `tag` WHERE `tag`.`IDTag` = '$IDTag'";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur de supression du tag : ' . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Tag supprimé : " . $tagName);

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