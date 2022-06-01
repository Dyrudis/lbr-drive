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
                    <a class="pointerOnHover" href="admin.php" style="text-decoration: none; color:white;">Gestion des comptes</a>
                    <a class="pointerOnHover">Gestion des tags/catégories</a>
                    <a class="pointerOnHover">Accéder à la corbeille</a>
                </div>
            </div>

            <?php
            if ($_SESSION['role'] != 'lecture') {
            ?>
                <!-- Divs pour créer tags ou catégories avec filtrage selon rôle -->
                <div id="create">

                    <div id="create-header" class="pointerOnHover">
                        <img class="create-arrow left" src="front/images/arrow.png">
                        <h3 id="create-title">Modifier</h3>
                        <img class="create-arrow right" src="front/images/arrow.png">
                    </div>

                    <?php
                    if ($_SESSION['role'] != 'invite') {
                    ?>
                        <div id="create-category">
                            <input type="text" name="category" id="category-input">
                            <input type="color" name="category-color" id="category-color-input">
                            <button id="create-category-button">Créer une catégorie</button>
                        </div>
                    <?php
                    }
                    ?>
                    <div id="create-tag">
                        <input type="text" name="tag" id="tag-input">
                        <select id="category-select">
                            <option disabled selected>Catégorie</option>
                            <?php
                            echo implode("", $categories);
                            ?>
                        </select>
                        <button id="create-tag-button">Créer un tag</button>
                    </div>
                    <div id="modif">

                        <button id="createCategory">Créer Catégorie</button>
                        <button id="createTag">Créer Tag</button>
                        <button id="modifSelectCat">Modifier Catégorie</button>
                        <button id="modifSelectTag">Modifier tag</button>

                        <!-- Choose category if modifCategory -->
                        <select name="modifCat" id="modifCat">
                            <option selected value="0" class="unselected">Catégorie</option>
                            <?php
                            echo implode("", $categories);
                            ?>
                        </select>

                        <!-- Choose Tag if modifTag -->
                        <select disabled name="modifTag" id="modifTag">
                            <option selected value="0" class="unselected">Tag</option>
                            <?php
                            echo implode("", $tags);
                            ?>
                        </select>

                        <!-- Choose name if rename -->
                        <input type="text" name="modifName" id="modifName">

                        <!-- Choose newCat if modifTag -->
                        <select name="modifFlex" id="modifFlex"></select>

                        <!-- Choose color if modifCat -->
                        <input type="color" name="modifColor" id="modifColor">

                        <!-- Validate rename -->
                        <button id="modifValidate">Appliquer</button>

                        <!-- Delete chosen Category/Tag -->
                        <button id="modifDelete">Supprimer</button>

                        <!-- Cancel -->
                        <button id="modifCancel">Annuler</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">

            </div>
        </div>
    </div>
</body>