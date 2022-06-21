<?php


$currentFile = explode('/', $_SERVER['REQUEST_URI']);
$currentFile = end($currentFile);


// Changement de couleur : thème clair
if ($_SESSION['darkMode'] == true) {
    echo "<script>

// HEADER

document.documentElement.style.setProperty('--primaryColor', '#FFFee6');

// ACCOUNT

document.documentElement.style.setProperty('--colorText', '#161619');
document.documentElement.style.setProperty('--colorBox', '#FFFFFF');
document.documentElement.style.setProperty('--colorThemeButton', 'black');
document.documentElement.style.setProperty('--colorThemeFont', 'white');

// UPLOAD

document.documentElement.style.setProperty('--colorDrop', '#fffee6');

// ADMIN

document.documentElement.style.setProperty('--colorFormAdmin', 'rgba(222, 222, 222, 1)');
document.documentElement.style.setProperty('--colorBodyAdmin', '#fffee6');
document.documentElement.style.setProperty('--colorH2Admin', 'rgb(92 92 92)');
document.documentElement.style.setProperty('--colorH3Admin', 'rgb(92 92 92)');
document.documentElement.style.setProperty('--colorLabelAdmin', 'rgb(92 92 92)');
document.documentElement.style.setProperty('--boxShadowAdmin', '0px 0px 15px 5px rgb(0 0 0 / 40%)');

// TAGS

document.documentElement.style.setProperty('--colorH2Tags', 'black');
document.documentElement.style.setProperty('--colorH3Tags', 'black');
document.documentElement.style.setProperty('--colorContainer', 'rgba(0, 0, 0, 0.1)');
document.documentElement.style.setProperty('--boxShadowTags', '0px 0px 10px 4px rgb(209, 209, 209)');
document.documentElement.style.setProperty('--colorPreviewTags', '#af001e');
document.documentElement.style.setProperty('--inputTags', 'rgb(255,255,255)');

// LOGS

document.documentElement.style.setProperty('--colorH1Logs', '#393939');
document.documentElement.style.setProperty('--colorH3Logs', 'black');
document.documentElement.style.setProperty('--colorLogs', 'rgb(222,222,222)');
document.documentElement.style.setProperty('--colorPLogs', 'black');

</script>";
// Changement de couleur : thème sombre
} else {
    echo "<script>

// HEADER
document.documentElement.style.setProperty('--primaryColor', '#161619');

// ACCOUNT 

document.documentElement.style.setProperty('--colorText', '#FFFFFF');
document.documentElement.style.setProperty('--colorBox', '#70726E');
document.documentElement.style.setProperty('--colorThemeButton', 'white');
document.documentElement.style.setProperty('--colorThemeFont', 'black');

// UPLOAD

document.documentElement.style.setProperty('--colorDrop', '#161619');

// ADMIN

document.documentElement.style.setProperty('--colorFormAdmin', 'rgb(16, 0, 16)');
document.documentElement.style.setProperty('--colorBodyAdmin', '#161920');
document.documentElement.style.setProperty('--colorH2Admin', 'rgb(255 255 255)');
document.documentElement.style.setProperty('--colorH3Admin', 'rgb(255 255 255)');
document.documentElement.style.setProperty('--colorLabelAdmin', 'rgb(255 255 255)');
document.documentElement.style.setProperty('--boxShadowAdmin', '0px 0px 10px 6px rgb(142, 139, 139)');

// TAGS

document.documentElement.style.setProperty('--colorH2Tags', 'white');
document.documentElement.style.setProperty('--colorH3Tags', 'white');
document.documentElement.style.setProperty('--colorContainer', 'rgba(0, 0, 0, 0.2)');
document.documentElement.style.setProperty('--boxShadowTags', '0px 0px 10px 4px rgb(139, 139, 139)');
document.documentElement.style.setProperty('--colorPreviewTags', '#662934');
document.documentElement.style.setProperty('--inputTags', 'rgb(192,192,192)');

// LOGS

document.documentElement.style.setProperty('--colorH1Logs', '#white');
document.documentElement.style.setProperty('--colorH3Logs', 'white');
document.documentElement.style.setProperty('--colorLogs', '#393939');
document.documentElement.style.setProperty('--colorPLogs', 'white');

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