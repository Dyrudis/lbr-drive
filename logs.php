<?php
session_start();

if($_SESSION['role']!='admin'){
    header('Location: index.php'); 
}
?>
<!DOCTYPE html>

<head>
    <title>Logs</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/JS/logs.js" defer></script>
    <link rel="stylesheet" href="front/CSS/logs.css">
</head>

<body>
    <?php
    include('header.php');
    ?>
    
    <div id="content">
        <h1>Liste des actions enregistrées</h1>
        <div id="logs"></div>
    </div>
</body>