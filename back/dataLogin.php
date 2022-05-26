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
$actif=2;
foreach($result as $info){
    $id = $info["IDUtilisateur"];
    $actif = $info["Actif"];
}

if ($result->num_rows > 0 && $actif=='1') {
    //connection réussit
    $_SESSION['id'] = $id;
    //echo" <p> id de session vaut ". $_SESSION['id'] ."</p>";
    header('Location: ../compte.php');
} else if($actif=='0'){
    echo" <p> votre compte a été banni <br><br>Rediection dans 2s</p>";
    header("refresh:2, url=../login.php");
    
}else{
    echo" <p>email ou mot de passe incorrect <br><br>Rediection dans 2s</p>";
    header("refresh:2, url=../login.php");

}

// Close the connection
$mysqli->close();
?>