<?php
include("../database.php");
session_start();

$IDFichier = $_POST['IDFichier'];
$IDTag = $_POST['IDTag'];


//Get the name of the tag
$tagName = "SELECT NomTag FROM tag WHERE IDTag = '$IDTag'";
$tagName = $mysqli->query($tagName)->fetch_assoc()['NomTag'];

//Check for errors
if (!$tagName) {
    die("Erreur lors de la récupération du nom du tag pour logs : " . $mysqli->error);
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

//Get the name of the file
$fileName = "SELECT Nom FROM fichier WHERE IDFichier = '$IDFichier'";
$fileName = $mysqli->query($fileName)->fetch_assoc()['Nom'];

//Check for errors
if (!$fileName) {
    die("Erreur lors de la récupération du nom du fichier pour logs : " . $mysqli->error);
}

// INSERT LOG
include '../logRegister.php';
registerNewLog($mysqli, $_SESSION['id'], "Retire le tag : " . $tagName . " au fichier : " . $fileName);

echo "OK";
