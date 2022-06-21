<?php


$currentFile = explode('/', $_SERVER['REQUEST_URI']);
$currentFile = end($currentFile);


// Changement de couleur : thème sombre
if ($_SESSION['darkMode'] == true) {
    echo "<script>

    document.documentElement.style.setProperty('--colorBackground', '#161619');
    document.documentElement.style.setProperty('--colorText', '#ffffff');
    document.documentElement.style.setProperty('--colorBox', '#100010');
    document.documentElement.style.setProperty('--colorInput', '#662934');
    document.documentElement.style.setProperty('--colorLabelInput', '#000000');
    document.documentElement.style.setProperty('--colorBoxShadow', '0px 0px 5px 3px #8e8b8b');
    document.documentElement.style.setProperty('--colorInputTags', '#c0c0c0');
    document.documentElement.style.setProperty('--colorBorder', '#414141');
    
    </script>";
// Changement de couleur : thème clair
} else {
    echo "<script>

    document.documentElement.style.setProperty('--colorBackground', '#FFFee6');
    document.documentElement.style.setProperty('--colorText', '#161619');
    document.documentElement.style.setProperty('--colorBox', '#dedede');
    document.documentElement.style.setProperty('--colorInput', '#af001e');
    document.documentElement.style.setProperty('--colorLabelInput', '#ffffff');
    document.documentElement.style.setProperty('--colorBoxShadow', '0px 0px 5px 3px #333333');
    document.documentElement.style.setProperty('--colorInputTags', '#ffffff');
    document.documentElement.style.setProperty('--colorBorder', '#000000');
    
    </script>";
}

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