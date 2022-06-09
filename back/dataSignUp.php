<?php
include("./database.php");
session_start();

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$description = $_POST['description'];
$role = $_POST['role'];
$checkBoxMdpTemporaire = json_decode($_POST['mdpTemporaire']);

if (isset($_POST['tags'])) {
    $tagAutorise = json_decode($_POST['tags']);
}

if (isset($_POST['motDePasse'])) {
    $motdepasse = $_POST['motDePasse'];
}

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$req = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($req);
if ($result->num_rows > 0) {
    echo "email incorrect";
} else {

    // INSERT LOG
    include './logRegister.php';
    registerNewLog($mysqli, $_SESSION['id'], "Ajout d'un utilisateur : " . $email);


    if ($checkBoxMdpTemporaire) {
        $mdpTemp = rand(100000, 999999);
        include('module/mailerInscription.php');
        $hash = password_hash($mdpTemp, PASSWORD_DEFAULT);

        $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '2')";
        $result = $mysqli->query($req);

        $idNouveauCompte = $mysqli->insert_id;
        if ($role == 'invite') {
            $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
            foreach ($tagAutorise as $tag) {
                $reqTagAutorise .= "(" . $idNouveauCompte . "," . $tag . "),";
            }
            $reqTagAutorise = substr($reqTagAutorise, 0, -1);
            $resultTagAutorise = $mysqli->query($reqTagAutorise);
            if ($result === TRUE) {
                echo "initialisation des tags de invité";
            } else {
                echo "Échec l'initialisation des tags de invité";
            }
        }

        if ($result === TRUE) {

            $subject = 'Inscription lbr drive';
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            $headers[] = 'From: noreply.lbr.drive@gmail.com';
            if (mail($email, $subject, $mailerInscription, implode("\r\n", $headers))) {
                echo "Email envoyé avec succès";
            } else {
                echo "Échec de l'envoi de l'email";
            }
        } else {
            echo "<p>echec de la création de compte";
        }
    } else {
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);
        $req = "INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES ('$nom','$prenom' ,'$hash', '$email', '$description','$role', '1')";
        $result = $mysqli->query($req);

        $idNouveauCompte = $mysqli->insert_id;
        if ($role == 'invite') {
            $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
            foreach ($tagAutorise as $tag) {
                $reqTagAutorise .= "(" . $idNouveauCompte . "," . $tag . "),";
            }
            $reqTagAutorise = substr($reqTagAutorise, 0, -1);
            $resultTagAutorise = $mysqli->query($reqTagAutorise);
            if ($result === TRUE) {
                echo "initialisation des tags de invité";
            } else {
                echo "Échec l'initialisation des tags de invité";
            }
        }

        if ($result === TRUE) {
            echo "Création de compte réussi";
        } else {
            echo "echec de la création de compte*";
        }
    }
}
