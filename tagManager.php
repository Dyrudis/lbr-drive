<!DOCTYPE html>
<html lang="en">

<head>
    <title>LBR Drive - Gestion des tags</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="front/css/alert.css">
    <link rel="stylesheet" href="front/css/tagManager.css">
    <link rel="icon" href="front/images/iconelbr.ico"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/js/alert.js" defer></script>
    <script src="front/js/tagManager.js" defer></script>
</head>

<?php
    session_start();
    if($_SESSION["role"] == "lecture"){
        header("Location: index.php");
    }
    include('header.php');
?>

<body id="bodytag">
    <div id="content">
        <div id="category">
            <h2>Catégories</h2>
            <div id="createCategories">
                <h3>Créer une catégorie : </h3>
                <form class="formModif" autocomplete="off">
                    <input type="text" name="categoryInput" id="categoryInput" placeholder="Nom de la catégorie">
                    <input type="color" name="categoryColor" id="categoryColor">
                    <input type="button" value="Créer" name="createCategory" id="createCategory">
                </form>
            </div>
            <div id="categoryContent"></div>
        </div>
        <div id="tag">
            <h2>Tags</h2>
            <div id="createTags">
                <h3>Créer un tag : </h3>
                <form class="formModif" autocomplete="off">
                    <input type="text" name="tagInput" id="tagInput" placeholder="Nom du tag">
                    <select name="categorySelected" id="categorySelected"></select>
                    <input type="button" value="Créer" name="createTag" id="createTag">
                </form>
            </div>
            <div id="tagContent"></div>
        </div>
    </div>
</body>
</html>
