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

try {
    //requete avec l'email entré dans la création de compte
    $stmt = $mysqli->prepare("SELECT * FROM utilisateur WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    //test si il y a au moins un resultat
    if ($stmt->num_rows > 0) {
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
            $stmt = $mysqli->prepare("INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES (?,? ,?, ?, ?,?, '2')");
            $stmt->bind_param("ssssss", $nom,$prenom ,$hash, $email, $description,$role);
            $stmt->execute();

            //recupere l'id de compte creer
            $idNouveauCompte = $mysqli->insert_id;

            //test si le role est invite
            if ($role == 'invite') {

                $stmt = $mysqli->prepare("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)");
                $stmt->bind_param("ii", $IDFichier, $currentTag);
                foreach ($tagAutorise as $tag) {
                    $currentTag = $tag;
                    $stmt->execute();
                }

                echo "Envoie du mail d'inscription au compte invité";
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
            $stmt = $mysqli->prepare("INSERT INTO utilisateur (Nom,Prenom, MotDePasse, Email, Description , Role, Actif) VALUES (?,? ,?, ?, ?,?, '1')");
            $stmt->bind_param("ssssss", $nom,$prenom ,$hash, $email, $description,$role);
            $stmt->execute();

            //recupere l'id de compte creer
            $idNouveauCompte = $mysqli->insert_id;

            //test si le role est invite
            if ($role == 'invite') {

                $stmt = $mysqli->prepare("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)");
                $stmt->bind_param("ii", $IDFichier, $currentTag);
                foreach ($tagAutorise as $tag) {
                    $currentTag = $tag;
                    $stmt->execute();
                }

                echo "Envoie du mail d'inscription au compte invité";
            }

            echo "Création de compte réussi";
        }
    }
}catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

