<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Nouveau mot de passe</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/css/login.css" />
    <link rel="icon" href="front/images/iconelbr.ico"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/js/account/resetPassword.js" defer></script>
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
        <h1>Demande de nouveau mot de passe</h1>

        <label for="email">email :</label>
        <input type="email" name="email" placeholder="xyz@hotmail.com" id="email" required>

        <input id="bouton" type="button" value="Envoie de mail" name="submit" onclick='submitResetMdp()'>

    </form>
</body>

</html>