<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Connection</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="CSS/login.css" />
        <link rel="stylesheet" href="CSS/style.css" />
    </head>

    <body>
        <header>
            <a id="lienHome" href="index.html">Home</a>
            <img src="images/logoLONGUEURBlanc.png" />
        </header>
        <div id="main">
            <form action="back/dataLogin.php" method="post">
            <p>email :</p>
            <input type="email" name="email" placeholder="email" required>
            <p>Mot de passe :</p>
            <input type="password" name="motdepasse" placeholder="motdepasse" required>
            <br>

            <input id="bouton"type="submit" value="Connection" name="submit">
            </form>
        </div>
    </body>
</html>
