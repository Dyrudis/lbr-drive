<?php
$currentFile = explode('/', $_SERVER['REQUEST_URI']);
$currentFile = end($currentFile);
?>

<header>

    <img id="menuToggle" src="front/images/menu.svg">

    <a id="home" class="pointerOnHover undraggable" href="index.php">
        <img src="front/images/logoLONGUEURBlanc.png">
    </a>

    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] != 'lecture') {
    ?>
        <a id="lienUpload" class="pointerOnHover undraggable" href="uploadFile.php">Ajouter un fichier</a>
    <?php
    }
    ?>
    <?php
    if (isset($_SESSION['id']) && $currentFile != 'account.php') {
    ?>
        <a id="lienCompte" class="pointerOnHover undraggable" href="account.php">Mon compte</a>
    <?php
    } else if (isset($_SESSION['id']) && $currentFile == 'account.php') {
    ?>
        <a id="lienCompte" class="pointerOnHover undraggable" href="back/account/logOut.php">Deconnexion</a>
    <?php
    }
    ?>
    <link rel="stylesheet" href="front/css/header.css" />
</header>