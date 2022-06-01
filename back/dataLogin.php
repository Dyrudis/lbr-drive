<?php
session_start();
$email = $_POST['email'];
$motdepasse = $_POST['motdepasse'];

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

$sql = "SELECT * FROM utilisateur WHERE Email = '$email'";
$result = $mysqli->query($sql);
foreach($result as $info){
    $id = $info['IDUtilisateur'];
    $actif = $info['Actif'];
    $mdpHash = $info['MotDePasse'];
    $role = $info['Role'];
}

if ($result->num_rows > 0 && password_verify($motdepasse,$mdpHash)) {
    if($actif=='2'){
        $_SESSION['id'] = $id;
        header('Location: ../nouveauMdp.php');
    }
    else if($actif=='1'){
        $_SESSION['id'] = $id;
        $_SESSION['role'] = $role;
        header('Location: ../index.php'); 
    }
    else if($actif=='0'){
        echo" <p> Votre compte est suspendu<br><br>Redirection dans 2s</p>";
        header("refresh:2, url=../login.php");
    }
}else {
    echo" <p>Identifiants incorrects<br><br>Redirection dans 2s</p>";
    header("refresh:2, url=../login.php");

}

// Close the connection
$mysqli->close();
?>