<?php
include("./database.php");
session_start();
include './logRegister.php';

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];

//IL FAUT ENCORE PERMETTRE A UN ADMIN DE RETIRER DES TAGS AUTORISES A UN INVITE
//IL FAUT ENCORE PERMETTRE A UN ADMIN DE RETIRER DES TAGS AUTORISES A UN INVITE
//IL FAUT ENCORE PERMETTRE A UN ADMIN DE RETIRER DES TAGS AUTORISES A UN INVITE
//IL FAUT ENCORE PERMETTRE A UN ADMIN DE RETIRER DES TAGS AUTORISES A UN INVITE

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
            echo "l'ajout des tags a été un succes";

            // INSERT LOG
            registerNewLog($mysqli, $_SESSION['id'], "Ajout d'un tag autorisé pour l'invité " . $email);
        } else {
            echo "Échec de l'ajout des tags ";
        }
    } else {
        echo "le compte n'est pas un compte invite";
    }
} else {
    if ($champ == 'MotDePasse') $valeur = password_hash($valeur, PASSWORD_DEFAULT);

    $sql = "UPDATE utilisateur SET $champ = '$valeur' WHERE Email = '$email'";
    $result = mysqli_query($mysqli, $sql);

    if ($result === TRUE) {
        echo "modification du compte réussie avec succès";

        // INSERT LOG
        registerNewLog($mysqli, $_SESSION['id'], "Modification du champ : " . $champ . " pour l'utilisateur : " . $email);
    } else {
        echo "echec de la modification du compte";
    }
}
