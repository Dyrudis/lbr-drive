<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

$emailTest = $_POST['email'];
$req = "SELECT * FROM utilisateur WHERE Email = '$emailTest'";
$result = $mysqli->query($req);

if ($result->num_rows > 0) {
    echo false;
}
else{
    echo true;
}

?>