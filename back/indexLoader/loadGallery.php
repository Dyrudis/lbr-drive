<?php
session_start();
include("../database.php");

//tab contenant les tags pour requete
$tab = [];
//string pour requete seulement fichiers à soi
$user = "";
//bool qui retient quel type de tri de tag effectuer (true = intersection)
$tri = true;
//string qui retient quel type de fichier à afficher (image, video, les deux)
$type = "";
//string qui retient si on affiche la corbeille ou non
$corbeille = "AND fichier.corbeille IS NULL ";

//récupération du role et de l'id du compte actuellement connecté
$role = $_SESSION['role'];
$id = $_SESSION['id'];

//Get incoming tab from post
if (isset($_POST['tags'])) {
    $tab = json_decode($_POST['tags']);
}

//Get incoming string from post
if (isset($_POST['user'])) {
    $user = "AND fichier.IDUtilisateur = '$id' ";
}

//Get incoming string from post
if (isset($_POST['typeTriTag'])) {
    $tri = false;
}

//Get incoming bool from post
if (isset($_POST['corbeille'])) {
    if ($_POST['corbeille'] == "true") {
        $corbeille = "AND fichier.corbeille IS NOT NULL ";
    }
}


if (isset($_POST['fileType'])) {
    $type = $_POST['fileType'];
    //Set $type de fichié recherché selon argument entrant
    if ($type == "image") {
        $type = "AND fichier.Type = 'image' ";
    } else if ($type == "video") {
        $type = "AND fichier.Type = 'video' ";
    } else {
        $type = " ";
    }
}

if ($role == 'invite') {
    $sql = "SELECT fichier.Nom as NomFichier, GROUP_CONCAT(classifier.IDTag) as 'IDTags', GROUP_CONCAT(tag.NomTag) as 'NomTags', GROUP_CONCAT(categorie.Couleur) 
    as 'CouleurTags', fichier.Date, fichier.Taille, fichier.Type, fichier.Extension, fichier.Duree, utilisateur.Nom, utilisateur.Prenom, utilisateur.IDUtilisateur, fichier.IDFichier, fichier.Corbeille
    FROM classifier, fichier, utilisateur, tag, categorie , restreindre
    WHERE fichier.IDFichier = classifier.IDFichier AND fichier.IDUtilisateur = utilisateur.IDUtilisateur AND classifier.IDTag = tag.IDTag AND tag.IDCategorie = categorie.IDCategorie AND restreindre.IDTag=classifier.IDTag 
    AND restreindre.IDUtilisateur = '$id' " . $user . " " . $type . $corbeille . " GROUP BY fichier.IDFichier;";

    $result = $mysqli->query($sql);
} else {
    // Get the data from the database
    $sql = "SELECT fichier.Nom as NomFichier, GROUP_CONCAT(classifier.IDTag) as 'IDTags', GROUP_CONCAT(tag.NomTag) as 'NomTags', GROUP_CONCAT(categorie.Couleur) 
    as 'CouleurTags', fichier.Date, fichier.Taille, fichier.Type, fichier.Extension, fichier.Duree, utilisateur.Nom, utilisateur.Prenom, utilisateur.IDUtilisateur, fichier.IDFichier, fichier.Corbeille
    FROM classifier, fichier, utilisateur, tag, categorie
    WHERE fichier.IDFichier = classifier.IDFichier AND fichier.IDUtilisateur = utilisateur.IDUtilisateur AND classifier.IDTag = tag.IDTag AND tag.IDCategorie = categorie.IDCategorie " . $user . " " . $type . $corbeille .
        "GROUP BY fichier.IDFichier";

    $result = $mysqli->query($sql);
}



// Check for errors
if (!$result) {
    die('Erreur de recuperation des fichiers : ' . $mysqli->error);
}

// Parse the result into an array and return it in js
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

$tmp = [];

//Recherche de type INTERSECTION
if ($tri || !$tab) {
    //Filters and returns only rows containing AT LEAST the researched tags

    foreach ($rows as $row) {
        $tags = explode(',', $row['IDTags']);
        $tags = array_map('intval', $tags);

        if (!array_diff($tab, $tags)) {

            $tmp[] = $row;
        }
    }
}

//Recherche de type UNION
else {

    foreach ($rows as $row) {
        $tags = explode(',', $row['IDTags']);
        $tags = array_map('intval', $tags);

        if (array_intersect($tags, $tab)) {
            $tmp[] = $row;
        }
    }
}

// Add a boolean property named 'isEditable' to each file
foreach ($tmp as $index => $value) {
    if ($value['IDUtilisateur'] === $_SESSION['id'] || $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'ecriture') {
        $tmp[$index]['isEditable'] = true;
    } else {
        $tmp[$index]['isEditable'] = false;
    }
}


echo json_encode($tmp);
