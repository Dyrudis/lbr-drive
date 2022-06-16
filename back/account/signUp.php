<?php
include("../database.php");
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

$authorized = ['admin'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour ajouter un tag");
}

try {
    //requete avec l'email entré dans la création de compte
    $result = query("SELECT * FROM utilisateur WHERE Email = ?", "s", $email);

    //test si il y a au moins un resultat
    if ($result) {
        echo "email incorrect";
    } else {

        // INSERT LOG
        include '../log/registerLog.php';
        registerNewLog($mysqli, $_SESSION['id'], "Ajout d'un utilisateur : " . $email);

        //si la case mot de passe temporaire est coché
        if ($checkBoxMdpTemporaire) {
            //creation mdp temporaire
            $mdpTemp = rand(100000, 999999);
            $hash = password_hash($mdpTemp, PASSWORD_DEFAULT);

            //requete pour créer un nouvel utilisateur
            query("INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES (?,? ,?, ?, ?,?, '2')", "ssssss", $nom,$prenom ,$hash, $email, $description,$role);

            //recupere l'id de compte creer
            $idNouveauCompte = $mysqli->insert_id;
            //test si le role est invite
            if ($role == 'invite') {                
                foreach ($tagAutorise as $tag) {
                    query("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)","ii",$idNouveauCompte,$tag);
                }

                echo "compte invité créé";
            }

            include('../mail/mailerInscription.php');

            $subject = 'Inscription lbr drive';
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            $headers[] = 'From: no-reply@lesbriquesrouges.fr';
            if (mail($email, $subject, $mailerInscription, implode("\r\n", $headers))) {
                echo "Email envoyé avec succès";
            } else {
                echo "Échec de l'envoi de l'email";
            }
        //si la case mot de passe temporaire n'est pas coché
        } else {
            $hash = password_hash($motdepasse, PASSWORD_DEFAULT);

            //requete pour créer un nouvel utilisateur
            query("INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES (?,? ,?, ?, ?,?, '1')", "ssssss", $nom,$prenom ,$hash, $email, $description,$role);

            //recupere l'id de compte creer
            $idNouveauCompte = $mysqli->insert_id;
            //test si le role est invite
            if ($role == 'invite') {                
                foreach ($tagAutorise as $tag) {
                    query("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)","ii",$idNouveauCompte,$tag);
                }
                echo "compte invité créé";
            }

            echo "Création de compte réussi";
        }

        //creation de la photo de profil par defaut
        copy("../../avatars/default.jpg", "../../avatars/" . $idNouveauCompte);
    }
}catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

