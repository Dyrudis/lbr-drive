<?php
session_start();
include("../database.php");

//liste des types/arguments qui seront bind à la requête
$typeToBind = "";
$argsToBind = [];
//tab contenant les tags pour requete
$tab = [];
//string pour requete seulement fichiers à soi
$user = "";
//bool qui retient quel type de tri de tag effectuer (true = intersection)
$tri = true;
//string qui retient quel type de fichier à afficher (image, video, les deux)
$type = "";
//string qui retient si on affiche la corbeille ou non
$corbeille = "AND fichier.Corbeille IS NULL ";

//récupération du role et de l'id du compte actuellement connecté
$role = $_SESSION['role'];
$id = $_SESSION['id'];

//Get incoming tab from post
if (isset($_POST['tags'])) {
    $tab = json_decode($_POST['tags']);
}

//Get incoming string from post
if (isset($_POST['user'])) {
    $user = "AND fichier.IDUtilisateur = ? ";
    $typeToBind .= "i";
    $argsToBind[] = $id;
}

//Get incoming string from post
if (isset($_POST['typeTriTag'])) {
    $tri = false;
}

//Get incoming bool from post
if (isset($_POST['corbeille'])) {
    if ($_POST['corbeille'] == "true") {
        $corbeille = "AND fichier.Corbeille IS NOT NULL ";

        //Suppression des outdated dans fichiers + db
        $sql = "SELECT IDFichier, Extension FROM fichier WHERE Corbeille IS NOT NULL AND Corbeille <= NOW() - INTERVAL 30 DAY";
        $result = query($sql, $typeToBind, $argsToBind);

        foreach ($result as $row) {
            $IDFichier = $row['IDFichier'];
            $filePath = "../../upload/" . $IDFichier . "." . $row['Extension'];
            if (file_exists($filePath)) {
                unlink($filePath);
                query("DELETE FROM fichier WHERE Corbeille IS NOT NULL AND Corbeille < NOW()");
            }
        }
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

try {

    // Get the data from the database
    $sql = "SELECT fichier.Nom as NomFichier, GROUP_CONCAT(classifier.IDTag) as 'IDTags', GROUP_CONCAT(tag.NomTag) as 'NomTags', GROUP_CONCAT(categorie.Couleur) 
    as 'CouleurTags', fichier.Date, fichier.Taille, fichier.Type, fichier.Extension, fichier.Duree, utilisateur.Nom, utilisateur.Prenom, utilisateur.IDUtilisateur, fichier.IDFichier, fichier.Corbeille
    FROM classifier, fichier, utilisateur, tag, categorie
    WHERE fichier.IDFichier = classifier.IDFichier AND fichier.IDUtilisateur = utilisateur.IDUtilisateur AND classifier.IDTag = tag.IDTag AND tag.IDCategorie = categorie.IDCategorie " . $user . $type . $corbeille .
        "GROUP BY fichier.IDFichier";

    $result = query($sql, $typeToBind, $argsToBind);

    if ($role == 'invite') {
        $rows = $result;
        $result = [];
        $tagRestreint = "SELECT IDTag FROM restreindre WHERE IDUtilisateur = $id";
        $resultTagRestreint = $mysqli->query($tagRestreint);
        $allTagRestreint = [];
        foreach ($resultTagRestreint as $row) {
            $allTagRestreint[] = intval($row['IDTag']);
        }
        foreach ($rows as $row) {
            $tags = explode(',', $row['IDTags']);
            $tags = array_map('intval', $tags);

            if (array_intersect($tags, $allTagRestreint)) {
                $result[] = $row;
            }
        }
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . " dans " . $e->getFile() . ":" . $e->getLine();
}

$filteredResult = [];

//Recherche de type INTERSECTION
if ($tri || !$tab) {
    //Filters and returns only rows containing AT LEAST the researched tags

    foreach ($result as $row) {
        $tags = explode(',', $row['IDTags']);
        $tags = array_map('intval', $tags);

        if (!array_diff($tab, $tags)) {
            $filteredResult[] = $row;
        }
    }
}

//Recherche de type UNION
else {

    foreach ($result as $row) {
        $tags = explode(',', $row['IDTags']);
        $tags = array_map('intval', $tags);

        if (array_intersect($tags, $tab)) {
            $filteredResult[] = $row;
        }
    }
}

// Add a boolean property named 'isEditable' to each file
foreach ($filteredResult as $index => $value) {
    if ($value['IDUtilisateur'] == $_SESSION['id'] || $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'ecriture') {
        $filteredResult[$index]['isEditable'] = true;
    } else {
        $filteredResult[$index]['isEditable'] = false;
    }
}


echo json_encode($filteredResult);
