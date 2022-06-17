<?php
include("../database.php");
session_start();

$email = $_POST['email'];
$mdpTemp = rand(100000,999999);
include('../mail/mailer.php');

try{
  $result = query("SELECT * FROM utilisateur WHERE Email = ?", "s", $email);
  
  if ($result) {
  
    if($result[0]['Actif']!='0'){
      $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
      query("UPDATE utilisateur SET MotDePasse = ? , Actif = '2' WHERE Email = ?", "ss", $hash ,$email);
      $subject = 'Reinitialisation de mot de passe';
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=utf-8';
      $headers[] = 'From: no-reply@lesbriquesrouges.fr';
      if(mail($email, $subject, $mailer, implode("\r\n", $headers))){
        echo "Succes";
      }else{
        echo "Echec";
      }
      session_destroy();
    }
    else{
        echo "compte suspendu";
    }
  }
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}


?>