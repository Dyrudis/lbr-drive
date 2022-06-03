<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($_SESSION['id']) {
    $id = $_SESSION['id'];
} else {
    header("Location: login.php");
}

$query = "SELECT * FROM categorie";
$result = $mysqli->query($query) or die($mysqli->error);
$categories = [];
while ($row = $result->fetch_assoc()) {
    if ($row['IDCategorie'] != "0") {
        $categories[] = "<option value=" . $row['IDCategorie'] . ">" . $row['NomCategorie'] . "</option>";
    }
}

$query = "SELECT * FROM tag";
$result = $mysqli->query($query) or die($mysqli->error);
$tags = [];
while ($row = $result->fetch_assoc()) {
    if ($row['IDTag'] != "0") {
        $tags[] = "<option value=" . $row['IDTag'] . ">" . $row['NomTag'] . "</option>";
    }
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
    <script src="front/JS/barre.js" defer></script>
    <script src="front/JS/create.js" defer></script>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div id="content">
        <div id="barre" class="undraggable">

            <div id="tri-primaire">
                <div class="pre-tri" id="toggle-mes-fichiers">
                    <p>Mes fichiers</p>
                </div>
                <div class="pre-tri tout-type" id="toggle-type-fichier">
                    <p>Image / Vidéo</p>
                </div>
                <div class="pre-tri Intersection" id="toggle-type-tri-tag">
                    <p>Intersection</p>
                </div>
            </div>

            <div id="liste-categories">
                <!-- Ici s'appenderont les categories -->
            </div>

            <div id="espace-admin" class="undraggable">
                <div id="espace-admin-title" class="pointerOnHover" onclick="$('#espace-admin').toggleClass('shown');">
                    <img src="front/images/arrow.png" class="undraggable">
                    <h3>Espace <?php if ($_SESSION['role'] == "invite") echo "invité";
                                else if ($_SESSION['role'] == "lecture") echo "lecteur";
                                else echo $_SESSION['role'] ?></h3>
                </div>
                <div id="espace-admin-links">
                    <a class="pointerOnHover" href="admin.php">Gestion des comptes</a>
                    <a class="pointerOnHover" href="gestionTags.php">Gestion des tags/catégories</a>
                    <a class="pointerOnHover">Accéder à la corbeille</a>
                </div>
            </div>

        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">

            </div>
        </div>
    </div>
</body>