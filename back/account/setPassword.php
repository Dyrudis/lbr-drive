<?php
include("../database.php");
session_start();

$id = $_SESSION['id'];
$motdepasse = $_POST['nouveauMdp'];

try{
    $result = query("SELECT * FROM utilisateur WHERE IDUtilisateur = ?", "i", $id);

    if ($result && $result[0]['Actif']=='2') {
        $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
        query("UPDATE utilisateur SET MotDePasse = ?, Actif= '1' WHERE IDUtilisateur = ?", "si", $hash, $id);
        echo "Succes";
    }
    else{
        echo "Echec";
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}
?>