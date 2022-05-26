<?php
session_start();

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Get all the data from the form
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$motdepasse = $_POST['motdepasse'];
$email = $_POST['email'];
$description = $_POST['description'];
$role = $_POST['role'];




// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

// Check if the username already exists
$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo "<p>The email already exists</p>";
    
} else {
    // Insert the data into the database
    $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$motdepasse', '$email', '$description','$role', '1')";

    if ($mysqli->query($req) === TRUE) {
        if(isset($_POST['mdpTemporaire'])){
            $_SESSION['mdpTemporaire'] = 1;
        }
        else{
            $_SESSION['mdpTemporaire'] = 0;            
        }
        echo "<p>le compte a bien été créer</p>";
        header('refresh:2, url= ../compte.php');
    } else {
        echo "<p>Error: " . $req . "<br>" . $mysqli->error . "</p>";
    }
}
// Close the connection
?>