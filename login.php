<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/login.css" />
    <link rel="stylesheet" href="front/CSS/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/JS/requeteAjax/requeteLogin.js" defer></script>

</head>

<body id="bodylogin">
    <?php
    include('header.php');
    ?>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form>
        <h1>Se connecter</h1>

        <label for="username">email :</label>
        <input class="inputLogin" type="email" name="email" placeholder="xyz@hotmail.com" id="email" autocomplete="off">

        <label for="password">Mot de passe :</label>
        <input class="inputLogin" type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe">

        <input id="bouton" class="submit" type="button" value="Connexion" onclick="submitLogin()" >
        <a id="mdpOublie" href="reinitialiserMdp.php"> mot de passe oublié ?</a>

    </form>
</body>

</html>