<?php
include("../database.php");
session_start();

$email = $_POST['email'];
$mdpTemp = rand(100000,999999);
include('../mail/mailer.php');

try{
  //requête des info d'un compte qui possède le même email
  $result = query("SELECT * FROM utilisateur WHERE Email = ?", "s", $email);
  
  //s'il existe un résultat
  if ($result) {
    //vérifie que le compte n'est pas suspendu
    if($result[0]['Actif']!='0'){
      $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);
      //applique un mdp temporaire et set le actif a 2
      query("UPDATE utilisateur SET MotDePasse = ? , Actif = '2' WHERE Email = ?", "ss", $hash ,$email);
      
      $subject = 'Reinitialisation de mot de passe';
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=utf-8';
      $headers[] = 'From: no-reply@lesbriquesrouges.fr';

      //envoye de mail
      if(mail($email, $subject, $mailer, implode("\r\n", $headers))){
        echo "Succes";
      }else{
        echo "Echec";
      }
    }
    else{
        echo "compte suspendu";
    }
  }
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}


?>