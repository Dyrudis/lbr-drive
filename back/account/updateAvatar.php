<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("Vous devez être connecté pour modifier votre avatar");
}

$chunk = $_FILES['chunk']['tmp_name'];
$extension = $_POST['extension'];
$id = $_POST['id'];
$currentChunkNumber = $_POST['currentChunkNumber'];
$totalChunkNumber = $_POST['totalChunkNumber'];
$IDUtilisateur = $_SESSION['id'];
$chunksPath = "../../avatars/chunks/";
$avatarPath = "../../avatars/";

// Si le fichier existe déjà, on le supprime
if (file_exists($avatarPath . $IDUtilisateur)) {
    unlink($avatarPath . $IDUtilisateur);
}

// Vérification du format du fichier
$authImg = array('jpeg', 'jpg', 'png', 'gif');

if (!in_array($extension, $authImg)) {
    die('Format de fichier invalide.');
}

// Upload du chunk
move_uploaded_file($chunk, $chunksPath . $id . "-" . $currentChunkNumber);

if ($currentChunkNumber < $totalChunkNumber) {
    die("Chunk received");
}

// Recomposition du fichier à partir des chunks
for ($i = 1; $i <= $totalChunkNumber; $i++) {
    // Récupération du chunk
    $file = fopen($chunksPath . $id . '-' . $i, 'r');
    $buffer = fread($file, filesize($chunksPath . $id . '-' . $i));
    fclose($file);

    // Ajout du chunk dans le fichier
    $final = fopen($avatarPath . $IDUtilisateur, 'a');
    fwrite($final, $buffer);
    fclose($final);

    // Suppression du chunk
    unlink($chunksPath . $id . '-' . $i);
}

// INSERT LOG
include("../database.php");
include '../log/registerLog.php';
registerNewLog($mysqli, $IDUtilisateur, "Modifie son avatar");

// S'il reste des chunks qui datent de plus de 24h, on les supprime
$files = glob($chunksPath . '*');
foreach ($files as $file) {
    if (filemtime($file) < time() - 60 * 60 * 24) {
        unlink($file);
    }
}

echo "OK";
