<?php
session_start();
$email = $_POST['email'];
$mdpTemp = rand(100000,999999);
include('module/mailer.php');
include('module/mailerInscription.php');

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {

  if($result->fetch_assoc('Actif')=='1'){
    $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
    $req = "UPDATE utilisateur SET MotDePasse = '$hash' , Actif = '2' WHERE Email = '$email'";
    $result1 = mysqli_query($mysqli,$req);
    $_SESSION['id']='';
    $subject = 'Reinitialisation de mot de passe';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: noreply.lbr.drive@gmail.com';
    if(mail($email, $subject, $mailer, implode("\r\n", $headers))){
      echo "Email envoyé avec succès à <br>Redirection dans 2s";
      header('refresh:2, url= ../login.php');
    }else{
      echo "Échec de l'envoi de l'email...<br>Redirection dans 2s";
      header('refresh:2, url= ../reinitialiserMdp.php');
    }
  }else if($result->fetch_assoc('Actif')=='2'){
    $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
    $req2 = "UPDATE utilisateur SET MotDePasse = '$hash' , Actif = '2' WHERE Email = '$email'";
    $result2 = mysqli_query($mysqli,$req2);
    $_SESSION['id']='';
    $subject = 'Reinitialisation de mot de passe';
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: noreply.lbr.drive@gmail.com';
    if(mail($email, $subject, $mailerInscription, implode("\r\n", $headers))){
      echo "Email envoyé avec succès à <br>Redirection dans 2s";
      header('refresh:2, url= ../login.php');
    }else{
      echo "Échec de l'envoi de l'email...<br>Redirection dans 2s";
      header('refresh:2, url= ../reinitialiserMdp.php');
    }
  }else if($result->fetch_assoc('Actif')=='0'){
      echo "Échec de l'envoi de l'email, votre compte est banni...<br>Redirection dans 3s";
      header('refresh:3, url= ../reinitialiserMdp.php');
  }

}
?>