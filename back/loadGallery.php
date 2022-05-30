<?php

$tab = [];

//Get incoming tab from post
if (isset($_POST['tags'])){
    $tab = json_decode($_POST['tags']);
}

// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Get the data from the database
$sql = "SELECT fichier.Nom as NomFichier, GROUP_CONCAT(IDTag) as 'IDTags', fichier.Date, fichier.Taille, fichier.Type, fichier.Extension, fichier.Duree, utilisateur.Nom, utilisateur.Prenom, fichier.IDFichier from classifier, fichier, utilisateur
WHERE fichier.IDFichier = classifier.IDFichier AND fichier.IDUtilisateur = utilisateur.IDUtilisateur
GROUP BY fichier.IDFichier";

$result = $mysqli->query($sql);


// Check for errors
if (!$result) {
    die('Erreur d\'insertion du fichier : ' . $mysqli->error);
}

// Parse the result into an array and return it in js
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

//Filters and returns only rows containing AT LEAST the researched tags
$tmp = [];
foreach($rows as $row){
    $tags = explode(',', $row['IDTags']);
    $tags = array_map('intval', $tags);
    if(!array_diff($tab, $tags)){
        
        $tmp[] = $row;
    }
}


echo json_encode($tmp);
