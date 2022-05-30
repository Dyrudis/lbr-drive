<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$motdepasse = isset($_POST['motdepasse']);
$email = $_POST['email'];
$description = $_POST['description'];
$role = $_POST['role'];
$checkBoxMdpTemporaire = isset($_POST['mdpTemporaire']);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$req = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($req);

if ($result->num_rows > 0) {
    echo "<p>email incorrect<br><br>Redirection dans 2s</p>";
    header('refresh:2, url= ../compte.php');
}
else if($checkBoxMdpTemporaire==='on'){
    $mdpTemp = rand(100000,999999);
    $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
    $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '-1')";
    if ($mysqli->query($req) === TRUE) {

        $subject = 'Inscription lbr drive';
        $message = 'test !';
        $headers = 'From: noreply.lbr.drive@gmail.com';
        echo"email = ". $email;
        if(mail($email, $subject, $message, $headers)){
            echo "Email envoyé avec succès à <br>Redirection dans 2s";
            header('refresh:2, url= ../compte.php');
        }else{
            echo "Échec de l'envoi de l'email...<br>Redirection dans 2s";
            header('refresh:2, url= ../compte.php');
        }
    }
    else{
        echo "<p>echec de la création de compte<br><br>Redirection dans 2s</p>";
        header('refresh:2, url= ../compte.php');
    }
}
else{
    $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
    $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '1')";
    if ($mysqli->query($req) === TRUE) {
        echo "<p>Création de compte réussi<br><br>Redirection dans 2s</p>";
        header('refresh:2, url= ../compte.php');
    }
    else{
        echo "<p>echec de la création de compte<br><br>Redirection dans 2s</p>";
        header('refresh:2, url= ../compte.php');
    }
    
}
?>