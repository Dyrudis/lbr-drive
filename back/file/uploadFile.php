<?php

include("../database.php");
$chunk = $_FILES['file']['tmp_name'];
$currentChunkNumber = $_POST['currentChunkNumber'];
$totalChunkNumber = $_POST['totalChunkNumber'];
$id = $_POST['id'];
$extension = $_POST['extension'];
$timestamp = $_POST['timestamp'];
$type = "invalid";
$name = $_POST['name'];
$duration = $_POST['duration'];
$tags = json_decode($_POST['tags']);
$chunksPath = "../../upload/chunks/";
$filePath = "../../upload/";

// Vérification de l'id du fichier
try {
    $result = query("SELECT * FROM fichier WHERE IDFichier = ?", "s", $id);
    if ($result) {
        die("Error: Un fichier possède déjà cet id");
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// Vérification des droits
session_start();
$authorized = ['admin', 'ecriture', 'invite'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $authorized)) {
    die("Vous n'avez pas les droits pour uploader des fichiers");
}

// Vérification du nom du fichier
if ($name == "") {
    die("Erreur : Fichier sans nom");
}

// Vérification du format du fichier
$authImg = array('jpeg', 'jpg', 'png', 'gif');
$authVid = array('mp4', 'avi', 'mpeg', 'mkv', 'mov', 'ogg', 'webm');

if (in_array($extension, $authImg)) {
    $type = 'image';
} else if (in_array($extension, $authVid)) {
    $type = 'video';
}

if ($type == 'invalid') {
    die('Format de fichier invalide.');
}

// Upload du chunk
move_uploaded_file($chunk, $chunksPath . $id . '-' . $currentChunkNumber . "." . $extension);

if ($currentChunkNumber < $totalChunkNumber) {
    die("Chunk received");
}

// Recomposition du fichier à partir des chunks
for ($i = 1; $i <= $totalChunkNumber; $i++) {
    // Récupération du chunk
    $file = fopen($chunksPath . $id . '-' . $i . "." . $extension, 'r');
    $buffer = fread($file, filesize($chunksPath . $id . '-' . $i . "." . $extension));
    fclose($file);

    // Ajout du chunk dans le fichier
    $final = fopen($filePath . $id . "." . $extension, 'a');
    fwrite($final, $buffer);
    fclose($final);

    // Suppression du chunk
    unlink($chunksPath . $id . '-' . $i . "." . $extension);
}

/*--------------------------------------------*\
|   Ajout du fichier dans la base de données   |
\*--------------------------------------------*/

try {
    // Ajout du fichier dans la base de données
    query(
        "INSERT INTO fichier (IDFichier, Nom, IDUtilisateur, Date, Taille, Type, Extension, Duree, Miniature) VALUES (?, ?, ?, CURRENT_DATE, ?, ?, ?, ?, ?)",
        "ssiissid",
        $id,
        $name,
        $_SESSION['id'],
        filesize($filePath . $id . "." . $extension),
        $type,
        $extension,
        $duration,
        $timestamp
    );

    // Si le tableau des tags est vide, on ajoute le tag "Sans tag"
    if (empty($tags)) {
        $tags = array(0);
    }

    // Ajout des tags dans la base de données
    foreach ($tags as $tag) {
        query("INSERT INTO classifier (IDFichier, IDTag) VALUES (?, ?)", "si", $id, $tag);
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine());
}

// INSERT LOG
include '../log/registerLog.php';
registerNewLog($mysqli, $_SESSION['id'], "Upload de fichier : " . $name);

// S'il reste des chunks qui datent de plus de 24h, on les supprime
$files = glob($chunksPath . '*');
foreach ($files as $file) {
    if (filemtime($file) < time() - 60 * 60 * 24) {
        unlink($file);
    }
}

die("OK");
