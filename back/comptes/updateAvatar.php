<?php
session_start();

// Get the informations
$avatar = $_FILES['avatar'];
$IDUtilisateur = $_SESSION['id'];

/*------------------------------------*\
|   Put the file in the upload folder  |
\*------------------------------------*/

$tmpAvatarPath = $avatar['tmp_name'];

if ($tmpAvatarPath == "") {
    die('Aucun fichier envoyé.');
}

$newAvatarPath = "../../avatars/" . $IDUtilisateur;

if (move_uploaded_file($tmpAvatarPath, $newAvatarPath)) {
    echo "OK";
} else {
    echo "Erreur lors de la modification de la photo de profile.";
}