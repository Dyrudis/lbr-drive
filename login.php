<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connection</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/login.css" />
    <link rel="stylesheet" href="front/CSS/style.css" />

</head>

<body id="bodylogin">
    <?php
    include('header.php');
    ?>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="back/dataLogin.php" method="post">
        <h1>Se connecter</h1>

        <label for="username">email :</label>
        <input type="email" name="email" placeholder="xyz@hotmail.com" id="username">

        <label for="password">Mot de passe :</label>
        <input type="password" name="motdepasse" id="password" placeholder="Mot de passe">

        <input id="bouton" type="submit" value="Connexion" name="submit">
        <a id="mdpOublie" href="reinitialiserMdp.php"> mot de passe oublié ?</a>

    </form>
</body>

</html>