<?php
$currentFile = explode('/', $_SERVER['REQUEST_URI']);
$currentFile = end($currentFile);
?>

<header>
    <a href="index.php">
        <img id="home" class="pointerOnHover undraggable" src="front/images/logoLONGUEURBlanc.png">
    </a>

    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] != 'lecture') {
    ?>
        <a id="lienUpload" class="undraggable" href="addfile.php">Upload un fichier</a>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['id']) && $currentFile != 'compte.php') {
    ?>
        <a id="lienCompte" class="undraggable" href="compte.php">Mon compte</a>
    <?php
    } else if (isset($_SESSION['id']) && $currentFile == 'compte.php') {
    ?>
        <a id="lienCompte" class="undraggable" href="back/logOut.php">Deconnexion</a>
    <?php
    }
    ?>
    <link rel="stylesheet" href="front/CSS/header.css" />
</header>