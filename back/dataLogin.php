<?php
session_start();
$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);
$actif=2;
foreach($result as $info){
    $id = $info['IDUtilisateur'];
    $actif = $info['Actif'];
    $mdpHash = $info['MotDePasse'];
}

if ($result->num_rows > 0 && $actif=='1' && password_verify($motdepasse,$mdpHash)) {
    //connection réussit
    $_SESSION['id'] = $id;
    //echo" <p> id de session vaut ". $_SESSION['id'] ."</p>";
    header('Location: ../compte.php');
} else if($actif=='0'){
    echo" <p> Votre compte est suspendu<br><br>Redirection dans 2s</p>";
    header("refresh:2, url=../login.php");
    
}else{
    echo" <p>Identifiants incorrects<br><br>Redirection dans 2s</p>";
    header("refresh:2, url=../login.php");

}

// Close the connection
$mysqli->close();
?>