<?php
include("./database.php");
session_start();

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];
if($champ=='MotDePasse'){
    $valeur = password_hash($valeur,PASSWORD_DEFAULT);
}
if($champ=='tag'){
    $reqRole = "SELECT * FROM utilisateur WHERE Email = '$email'";
    $resultRole = $mysqli->query($reqRole);
    foreach($resultRole as $info){
        $id = $info['IDUtilisateur'];
        $role = $info['Role'];
    }
    if($role=='invite'){
        $tagAutorise = json_decode($_POST['tags']);
        $reqTagAutorise = "INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES ";
        foreach($tagAutorise as $tag){
            $reqTagAutorise.= "(" . $id . "," . $tag . "),";
        }
        $reqTagAutorise = substr($reqTagAutorise, 0, -1); 
        $resultTagAutorise = $mysqli->query($reqTagAutorise);
        if ($resultTagAutorise === TRUE) {
            echo "l'ajout des tags a été un succes";
        }
        else{
            echo "Échec de l'ajout des tags ";
        }

    }
    else{
        echo "le compte n'est pas un compte invite";
    }
}
else{
    $sql = "UPDATE utilisateur SET $champ = '$valeur' WHERE Email = '$email'";
    $result = mysqli_query($mysqli,$sql);
    if($result === TRUE){
        echo "modification du compte réussie avec succès";
    }
    else{
        echo"echec de la modification du compte";
    }
    


}

?>