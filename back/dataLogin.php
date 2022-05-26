<?php
session_start();
// Get all the data from the form
$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];


// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

// Check l'existance de l'adresse email
$sql = "SELECT * FROM utilisateur WHERE Email = '$email' AND MotDePasse ='$motdepasse'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    //connection réussit
    $_SESSION['id'] = $result->fetch_assoc()['IDUtilisateur'];
    //echo" <p> id de session vaut ". $_SESSION['id'] ."</p>";
    header('Location: ../compte.php');
} else {
    // compte invalide
    header("Location: ../login.php");
    
}

// Close the connection
$mysqli->close();
?>