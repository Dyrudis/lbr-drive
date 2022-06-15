<?php

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour ajouter un fichier");
}

$file = $_FILES['file'];
$name = $_POST['name'];
$duration = $_POST['duration'];
$tags = json_decode($_POST['tags']);
$type = "invalid"; // Invalid by default
$tmp = explode('.', $file['name']);
$extension = end($tmp);

if ($name == "") {
    die("Erreur : Fichier sans nom");
}

// Vérification du format du fichier
$authImg = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
$authVid = array('video/mp4', 'video/avi', 'video/mpeg', 'video/mkv', 'video/mov', 'video/ogg', 'video/webm');

if (in_array($file['type'], $authImg)) {
    $type = 'image';
} else if (in_array($file['type'], $authVid)) {
    $type = 'video';
}

if ($type == 'invalid') {
    die('Format de fichier invalide.');
}

$tmpFilePath = $file['tmp_name'];

if ($tmpFilePath == "") {
    die('Aucun fichier envoyé.');
}

/*--------------------------------------------*\
|   Ajout du fichier dans la base de données   |
\*--------------------------------------------*/

include("../database.php");

try {
    // Ajout du fichier dans la base de données
    query("INSERT INTO fichier (Nom, IDUtilisateur, Date, Taille, Type, Extension, Duree)VALUES (?, ?, CURRENT_DATE, ?, ?, ?, ?)",
    "sissss", $name, $_SESSION['id'], $file['size'], $type, $extension, $duration);

    // Récupération de l'ID du fichier
    $IDFichier = $mysqli->insert_id;

    // Si le tableau des tags est vide, on ajoute le tag "Sans tag"
    if (empty($tags)) {
        $tags = array(0);
    }

    // Ajout des tags dans la base de données
    foreach ($tags as $tag) {
        query("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, ?)", "si", $IDFichier, $tag);
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

/*------------------------------------------------*\
|   Déplacement du fichier dans le dossier upload  |
\*------------------------------------------------*/

$newFilePath = "../../upload/" . $IDFichier . "." . $extension;
if (move_uploaded_file($tmpFilePath, $newFilePath)) {
    echo "success";
} else {
    die("Erreur lors de l'envoi du fichier.");
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Upload de fichier : " . $name);
