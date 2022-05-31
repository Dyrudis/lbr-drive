<?php
session_start();
$email = $_POST['email'];

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $mdpTemp = rand(100000,999999);
    $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
    $req = "UPDATE utilisateur SET MotDePasse = '$hash' , Actif = '2' WHERE Email = '$email'";
    $result2 = mysqli_query($mysqli,$req);
    $_SESSION['id']='';

    $subject = 'Reinitialisation de mot de passe';
    $message = 'veuillez vous connecter sur le site avec le mot de passe temporaire suivant : <br> mot de passe temporaire :' . $mdpTemp . '<br>Vous pouvez accéder au site via ce lien : ';
    $headers = 'From: noreply.lbr.drive@gmail.com';
    if(mail($email, $subject, $message, $headers)){
        echo "Email envoyé avec succès à : " . $email;
        echo "Mot de passe temporaire : " . $mdpTemp;
        echo "<a id='lienCompte' href='../login.php'>acceder à la page de connexion</a> ";
    }else{
        echo "Échec de l'envoi de l'email...<br>Redirection dans 2s";
        header('refresh:2, url= ../reinitialiserMdp.php');
    }

}
?>