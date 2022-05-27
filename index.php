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
    <script src="https://unpkg.com/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/JS/gallery.js" defer></script>
    <script src="./front/JS/barre.js" defer></script>
</head>

<body>
    <header>
        <p id="home" class="pointerOnHover undraggable">Home</p>
        <img src="front/images/logoLONGUEURBlanc.png" class="undraggable" />
        <?php

        $sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            if ($result->fetch_assoc()['Role'] != 'lecture') {
        ?>
                <a id="lienUpload" class="undraggable" href="addfile.php"> Upload un fichier</a>
        <?php
            }
        }
        ?>
        <a id="lienCompte" class="undraggable" href="compte.php">Mon compte</a>    
    </header>

    <div id="content">
        <div id="barre" class="undraggable">
            <div>
                Filtrer par tag
                <p id="lineunderfilter"> </p>
            </div>
            <div id="liste-categories">
                <!-- Ici s'appenderont les categories -->
            </div>
        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">
                
            </div>
        </div>
    </div>
</body>