<?php
include("../database.php");
session_start();
include '../log/registerLog.php';

$email = $_POST['email'];
$champ = $_POST['champ'];
$valeur = $_POST['valeur'];
if($champ == 'Role'){
    $valeur = $_POST['nouveauRole'];
}


$authorized = ['admin'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour ajouter un tag");
}

try{
    
    //changement du champ tag pour l'invité
    if ($champ == 'tag') {

        //requete pour avoir l'id et le role du compte invité à modifier
        $result = query("SELECT * FROM utilisateur WHERE Email = ?", "s", $email);
        $idCompte = $result[0]['IDUtilisateur'];
        $roleCompte = $result[0]['Role'];

        //vérification que c'est un invité
        if($roleCompte=='invite'){

            //retire tous ses tag de restriction existant
            query("DELETE FROM restreindre WHERE IDUtilisateur = ?", "i", $idCompte);

            $tagAutorise = json_decode($_POST['tags']);
            // push les tags restreint associé au compte 
            foreach ($tagAutorise as $tag) {
                query("INSERT INTO restreindre (IDUtilisateur, IDTag) VALUES (?, ?)", "ii", $idCompte, $tag);
            }

            echo"Succes invite";
            // INSERT LOG
            registerNewLog($mysqli, $_SESSION['id'], "Modification des tags autorisés pour l'invité " . $email);

        } else {
            echo "Echec invite";
        }
    } else {

        //vérification si c'est un mot de passe a modifier afin de le hasher
        if ($champ == 'MotDePasse'){
            $valeur = password_hash($valeur, PASSWORD_DEFAULT);
        } 

        //verification si l'email existe déjà
        else if($champ == 'Email'){
            $result = query("SELECT * FROM utilisateur WHERE Email = ?", "s" , $valeur);
            if($result){
                die("email incorrect");
            }
        }

        //requete update du champ
        query("UPDATE utilisateur SET $champ = ? WHERE Email = ?", "ss" ,$valeur, $email);

        echo"Succes"; 

        // INSERT LOG
        if($champ == "Email") registerNewLog($mysqli, $_SESSION['id'], "Modification de l'adresse email de l'utilisateur " . $email . " pour : " . $valeur);
        else registerNewLog($mysqli, $_SESSION['id'], "Modification du champ : " . $champ . " pour l'utilisateur : " . $email);
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
