<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($_SESSION['id']) {
    $id = $_SESSION['id'];
} else {
    header("Location: login.php");
}

?>
<!DOCTYPE html>

<head>
    <title>Espace de stockage</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/JS/gallery.js" defer></script>
</head>

<body>
    <header>
        <p id="home" class="pointerOnHover">Home</p>
        <img src="front/images/logoLONGUEURBlanc.png" />
        <?php

        $sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            if ($result->fetch_assoc()['Role'] != 'lecture') {
        ?>
                <a id="lienUpload" href="addfile.php"> Upload un fichier</a>
        <?php
            }
        }
        ?>
        <a id="lienCompte" href="compte.php">Mon compte</a>    
    </header>

    <div id="content">
        <div id="barre">
            <div>
                Filtrer par tag
                <p id="lineunderfilter"> </p>
            </div>
            <div class="list-tags">
                <div class="category">
                    <p id="title-tag">Année</p>
                    <div id="taglist"></div>
                </div>
                <div class="category">
                    <p id="title-tag">Type de fichier</p>
                    <div id="taglist"></div>
                </div>
                <div class="category">
                    <p id="title-tag">Autres</p>
                    <div id="taglist"></div>
                </div>

                <div class="category">
                    <p id="title-tag">Ce que tu veux</p>
                    <div id="taglist"></div>
                </div>

                <div class="category">
                    <p id="title-tag">Créer une catégorie</p>
                    <div id="taglist"></div>
                </div>
            </div>
        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">
                <div id="col-1">
                </div>
                <div id="col-2">
                </div>
                <div id="col-3">
                </div>
                <div id="col-4">
                </div>
            </div>
        </div>
    </div>
</body>