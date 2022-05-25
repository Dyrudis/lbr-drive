<?php
// Get the informations
$file = $_FILES['file'];
$name = $_POST['name'];
$duration = $_POST['duration'];
$tags = json_decode($_POST['tags']);
$date = date("Y-m-d");
$type = "invalid"; // Invalid by default
$tmp = explode('.', $file['name']);
$extension = end($tmp);

// Check if the file is in a valid format
$authImg = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
$authVid = array('video/mp4', 'video/avi', 'video/mpeg', 'video/mkv', 'video/mov', 'video/ogg', 'video/webm');

if (in_array($file['type'], $authImg)) {
    $type = 'image';
} else if (in_array($file['type'], $authVid)) {
    $type = 'video';
}

if ($type != "invalid") {
    //Get the temp file path
    $tmpFilePath = $file['tmp_name'];

    //Make sure we have a file path
    if ($tmpFilePath != "") {

        //Setup our new file path
        $newFilePath = "../upload/" . $file['name'];

        //Upload the file into the temp dir
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {

            //Handle other code here

        }
    }
}

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Insert the data into the database
$sql = "INSERT INTO `fichier` (`IDFichier`, `Nom`, `IDUtilisateur`, `Date`, `Taille`, `Type`, `Extension`, `Duree`)
VALUES (NULL, '" . $name . "', 0, '" . $date . "', " . $file["size"] . ", '" . $type . "', '" . $extension . "', " . $duration . ");";
$result = $mysqli->query($sql);

// Check for errors
if (!$result) {
    die('Error: ' . $mysqli->error);
}

// Get the IDFichier we just inserted
$IDFichier = $mysqli->insert_id;



$sql = "INSERT INTO `classifier` (`IDFichier`, `IDTag`) VALUES (";

// for each tag
foreach ($tags as $tag) {
    // Add an array to the query
    $sql += "IDFichier`, `Nom`)";
}

// Close the connection
$mysqli->close();
