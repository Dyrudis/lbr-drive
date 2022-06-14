<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Nouveau mot de passe</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/css/login.css" />
    <link rel="icon" href="front/images/iconelbr.ico"/>
</head>

<body id="bodylogin">
    <?php
    include('header.php');
    ?>

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="back/account/resetPassword.php" method="post">
        <h1>Demande de nouveau mot de passe</h1>

        <label for="username">email :</label>
        <input type="email" name="email" placeholder="xyz@hotmail.com" id="username">

        <input id="bouton" type="submit" value="Envoie de mail" name="submit">

    </form>
</body>

</html>