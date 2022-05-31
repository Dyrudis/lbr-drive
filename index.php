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
    <script src="front/JS/barre.js" defer></script>
    <script src="front/JS/create.js" defer></script>
</head>

<body>
    <header>
        <p id="home" class="pointerOnHover undraggable">Home</p>
        <img src="front/images/logoLONGUEURBlanc.png" class="undraggable" />
        <?php
        if ($_SESSION['role'] != 'lecture') {
        ?>
            <a id="lienUpload" class="undraggable" href="addfile.php"> Upload un fichier</a>
        <?php
        }
        ?>
        <a id="lienCompte" class="undraggable" href="compte.php">Mon compte</a>
    </header>

    <div id="content">
        <div id="barre" class="undraggable">
            <div id="liste-categories">
                <!-- Ici s'appenderont les categories -->
            </div>

            <?php
            if ($_SESSION['role'] != 'lecture') {
            ?>
                <!-- Divs pour créer tags ou catégories avec filtrage selon rôle -->
                <div id="create">

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
                            $query = "SELECT * FROM categorie";
                            $result = $mysqli->query($query) or die($mysqli->error);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <option value="<?php echo $row['IDCategorie']; ?>"><?php echo $row['NomCategorie']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <button id="create-tag-button">Créer un tag</button>
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