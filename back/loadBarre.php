<?php 
    // Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "", "lbr_drive");

    // Verif error
    if ($mysqli->connect_errno) {
        echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    // SELECT all tags from bdd
    $sql = "SELECT NomTag, NomCategorie, Couleur FROM tag, categorie WHERE tag.IDCategorie = categorie.IDCategorie";
    $result = $mysqli->query($sql);

    // Verif error
    if (!$result) {
        echo "Echec lors de la requete : (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // Parse result into array and return it to JS
    $tags = array();
    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }
    echo json_encode($tags);
?>