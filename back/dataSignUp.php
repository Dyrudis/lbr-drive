<?php
session_start();

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'testb');

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
$sql = "SELECT * FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
$result = $mysqli->query($sql);


while ($result->num_rows > 0){
    $idUtilisateur++;
    $sql = "SELECT * FROM utilisateur WHERE idUtilisateur = '$idUtilisateur'";
    $result = $mysqli->query($sql);
}
if ($result->num_rows > 0) {
    echo "<p>The username already exists</p>";
    
} else {
    // Insert the data into the database
    $req = "INSERT INTO utilisateur (nom,prenom, motdepasse, email, description ,idUtilisateur, role) VALUES ('$nom','$prenom' ,'$motdepasse', '$email', '$description','$idUtilisateur','$role')";

    if ($mysqli->query($req) === TRUE) {
        echo "<p>New record created successfully</p>";
        if(isset($_POST['mdpTemporaire'])){
            $_SESSION['mdpTemporaire'] = 1;
        }
        else{
            $_SESSION['mdpTemporaire'] = 0;            
        }
        //header('Location: ../compte.php');
    } else {
        echo "<p>Error: " . $req . "<br>" . $mysqli->error . "</p>";
    }
}
// Close the connection
?>