<?php
session_start();
$id = $_SESSION['id'];
$motdepasse = $_POST['newMdp'];

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

$req = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
$result = $mysqli->query($req);

if ($result->num_rows > 0) {
    $hash = password_hash($motdepasse,PASSWORD_DEFAULT);
    $sql = "UPDATE utilisateur SET MotDePasse = '$hash', Actif= '1' WHERE IDUtilisateur = '$id'";
    $result = mysqli_query($mysqli,$sql);
    echo "Nouveau mot de passe enregistrer...<br>Redirection dans 2s";
    header('refresh:2, url= ../compte.php');
}
else{
    echo "Échec du nouveau mot de passe...<br>Redirection dans 2s";
    header('refresh:2, url= ../nouveauMdp.php');
}
?>