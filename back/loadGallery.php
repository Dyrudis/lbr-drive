<?php
session_start();

//tab contenant les tags pour requete
$tab = [];
//string pour requete seulement fichiers à soi
$user = "";
//bool qui retient quel type de tri de tag effectuer (true = intersection)
$tri = true;

//Get incoming tab from post
if (isset($_POST['tags'])) {
    $tab = json_decode($_POST['tags']);
}

//Get incoming string from post
if (isset($_POST['user'])) {
    $user = $_SESSION['id'];
    $user = "AND fichier.IDUtilisateur = '$user' ";
}

//Get incoming string from post
if (isset($_POST['typeTriTag'])) {
    $tri = false;

}
// Connect to the database with mysqli
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

// Check for errors
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

// Get the data from the database
$sql = "SELECT fichier.Nom as NomFichier, GROUP_CONCAT(classifier.IDTag) as 'IDTags', GROUP_CONCAT(tag.NomTag) as 'NomTags', GROUP_CONCAT(categorie.Couleur) as 'CouleurTags', fichier.Date, fichier.Taille, fichier.Type, fichier.Extension, fichier.Duree, utilisateur.Nom, utilisateur.Prenom, utilisateur.IDUtilisateur, fichier.IDFichier
FROM classifier, fichier, utilisateur, tag, categorie
WHERE fichier.IDFichier = classifier.IDFichier AND fichier.IDUtilisateur = utilisateur.IDUtilisateur AND classifier.IDTag = tag.IDTag AND tag.IDCategorie = categorie.IDCategorie " . $user . 
"GROUP BY fichier.IDFichier";

$result = $mysqli->query($sql);


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
if ($tri) {
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
