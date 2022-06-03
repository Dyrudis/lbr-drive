<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des tags/catégories</title>
    <link rel="stylesheet" href="front/CSS/gestionTags.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/js/gestionTags.js" defer></script>
</head>

<body>
    <?php
    include('header.php');
    ?>
    <div id="content">
        <div id="category">
            <h2>Catégories</h2>
            <div id="categoryContent"></div>
        </div>
        <div id="tag">
            <h2>Tags</h2>
            <div id="tagContent"></div>
        </div>
    </div>
</body>

</html>