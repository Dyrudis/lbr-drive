<?php
session_start();

$avatar = $_FILES['avatar'];
$IDUtilisateur = $_SESSION['id'];

$tmpAvatarPath = $avatar['tmp_name'];

if ($tmpAvatarPath == "") {
    die('Aucun fichier envoyé.');
}

// Vérification que le fichier est une image
$allowed = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
$avatarMime = $avatar['type'];
if (!in_array($avatarMime, $allowed)) {
    die('Format de fichier invalide.');
}

$newAvatarPath = "../../avatars/" . $IDUtilisateur;

if (move_uploaded_file($tmpAvatarPath, $newAvatarPath)) {

    include("../database.php");
    // INSERT LOG
    include '../log/registerLog.php';
    registerNewLog($mysqli, $IDUtilisateur, "Modifie son avatar");

    echo "OK";
} else {
    echo "Erreur lors de la modification de la photo de profile.";
}
