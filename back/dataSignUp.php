<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$description = $_POST['description'];
$role = $_POST['role'];

if(isset($_POST['tags'])){
    $tagAutorise = json_decode($_POST['tags']);
}

if(isset($_POST['motDePasse'])){
    $motdepasse = $_POST['motDePasse'];
}
if(isset($_POST['mdpTemporaire'])){
    $checkBoxMdpTemporaire = $_POST['mdpTemporaire'];
}

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
    include('module/mailerInscription.php');
    $hash = password_hash($mdpTemp,PASSWORD_DEFAULT);

    $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '2')";
    $result = $mysqli->query($req);

    $idNouveauCompte = $mysqli->insert_id;
    if($role=='invite'){
        $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
        foreach($tagAutorise as $tag){
            $reqTagAutorise.= "(" . $idNouveauCompte . "," . $tag . "),";
        }
        $reqTagAutorise = substr($reqTagAutorise, 0, -1); 
        $resultTagAutorise = $mysqli->query($reqTagAutorise);
        if ($result === TRUE) {
            echo "initialisation des tags de invité";
        }
        else{
            echo "Échec l'initialisation des tags de invité...<br>Redirection dans 3s";
            header('refresh:3, url= ../compte.php');
        }

    }

    if ($result === TRUE) {

        $subject = 'Inscription lbr drive';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: noreply.lbr.drive@gmail.com';
        if(mail($email, $subject, $mailerInscription, implode("\r\n", $headers))){
            echo "Email envoyé avec succès <br>Redirection dans 2s";
            header('refresh:2, url= ../compte.php');
        }else{
            echo "Échec de l'envoi de l'email...<br>Redirection dans 3s";
            header('refresh:3, url= ../compte.php');
        }
    }
    else{
        echo "<p>echec de la création de compte<br><br>Redirection dans 3s</p>";
        header('refresh:3, url= ../compte.php');
    }
}
else{
    $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
    $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '1')";
    $result = $mysqli->query($req);

    $idNouveauCompte = $mysqli->insert_id;
    if($role=='invite'){
        $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
        foreach($tagAutorise as $tag){
            $reqTagAutorise.= "(" . $idNouveauCompte . "," . $tag . "),";
        }
        $reqTagAutorise = substr($reqTagAutorise, 0, -1); 
        $resultTagAutorise = $mysqli->query($reqTagAutorise);
        if ($result === TRUE) {
            echo "initialisation des tags de invité";
        }
        else{
            echo "Échec l'initialisation des tags de invité...<br>Redirection dans 3s";
            header('refresh:3, url= ../compte.php');
        }

    }
    
    if ($result === TRUE) {
        echo "<p>Création de compte réussi<br><br>Redirection dans 2s</p>";
        header('refresh:2, url= ../compte.php');
    }
    else{
        echo "<p>echec de la création de compte<br><br>Redirection dans 3s</p>";
        header('refresh:3, url= ../compte.php');
    }
    
}
?>