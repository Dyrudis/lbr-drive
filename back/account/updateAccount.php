<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];

if ($champ == 'tag') {
    $reqRole = "SELECT * FROM utilisateur WHERE Email = '$email'";
    $resultRole = $mysqli->query($reqRole);
    foreach ($resultRole as $info) {
        $id = $info['IDUtilisateur'];
        $role = $info['Role'];
    }
    if($role=='invite'){
        $reqDelete = "DELETE FROM restreindre WHERE IDUtilisateur = $id";
        $resultDelete = $mysqli->query($reqDelete);
        $tagAutorise = json_decode($_POST['tags']);
        $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
        foreach ($tagAutorise as $tag) {
            $reqTagAutorise .= "(" . $id . "," . $tag . "),";
        }
        $reqTagAutorise = substr($reqTagAutorise, 0, -1);
        $resultTagAutorise = $mysqli->query($reqTagAutorise);
        if ($resultTagAutorise === TRUE) {
            echo "Tags autorisés modifiés";

            // INSERT LOG
            registerNewLog($mysqli, $_SESSION['id'], "Modification des tags autorisés pour l'invité " . $email);
        } else {
            echo "Échec de la modification des tags autorisés";
        }
    } else {
        echo "Le compte n'est pas un compte invité";
    }
} else {
    if ($champ == 'MotDePasse') $valeur = password_hash($valeur, PASSWORD_DEFAULT);

    $sql = "UPDATE utilisateur SET $champ = '$valeur' WHERE Email = '$email'";
    $result = mysqli_query($mysqli, $sql);

    if ($result === TRUE) {
        echo "Modification du compte réussie";

        // INSERT LOG
        if($champ != "Email") registerNewLog($mysqli, $_SESSION['id'], "Modification de l'adresse email de l'utilisateur " . $email . " pour : " . $valeur);
        else registerNewLog($mysqli, $_SESSION['id'], "Modification du champ : " . $champ . " pour l'utilisateur : " . $email);
    } else {
        echo "Echec de la modification du compte";
    }
}
