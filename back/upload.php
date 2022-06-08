<?php
session_start();

// Get the informations
$file = $_FILES['file'];
$name = $_POST['name'];
$duration = $_POST['duration'];
$tags = json_decode($_POST['tags']);
$date = date("Y-m-d");
$type = "invalid"; // Invalid by default
$tmp = explode('.', $file['name']);
$extension = end($tmp);

if ($name == "Test Error") {
    die("Erreur : Ceci est un test");
}

// Check if the file is in a valid format
$authImg = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
$authVid = array('video/mp4', 'video/avi', 'video/mpeg', 'video/mkv', 'video/mov', 'video/ogg', 'video/webm');

if (in_array($file['type'], $authImg)) {
    $type = 'image';
} else if (in_array($file['type'], $authVid)) {
    $type = 'video';
}

if ($type == 'invalid') {
    die('Format de fichier invalide.');
}

// Get the temp file path
$tmpFilePath = $file['tmp_name'];

if ($tmpFilePath == "") {
    die('Aucun fichier envoyé.');
}



/*------------------------------------*\
|   Add all the info to the database   |
\*------------------------------------*/

include("../database.php");

// Insert the data into the database
$sql = "INSERT INTO `fichier` (`IDFichier`, `Nom`, `IDUtilisateur`, `Date`, `Taille`, `Type`, `Extension`, `Duree`, `Corbeille`)
VALUES (NULL, '$name', " . $_SESSION['id'] . ", '$date', " . $file['size'] . ", '$type', '$extension', '$duration', NULL);";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion du fichier : ' . $mysqli->error);
}



// Get the IDFichier we just inserted
$IDFichier = $mysqli->insert_id;

// If the tags array is empty, add a default tag
if (empty($tags)) {
    $tags = array(0);
}

// Insert the tags into the database
$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES ";
foreach ($tags as $tag) {
    // Add an array to the query
    $sql .= "(" . $IDFichier . ", " . $tag . "),";
}
$sql = substr($sql, 0, -1); // Pop last comma
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Erreur d\'insertion des tags : "' . $sql . '". ' . $mysqli->error);
}

// Close the connection
$mysqli->close();



/*------------------------------------*\
|   Put the file in the upload folder  |
\*------------------------------------*/

$newFilePath = "../upload/" . $IDFichier . "." . $extension;
if (move_uploaded_file($tmpFilePath, $newFilePath)) {
    echo "success";
} else {
    echo "Erreur lors de l'envoi du fichier.";
}
