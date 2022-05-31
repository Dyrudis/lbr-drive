<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Nouveau mot de passe</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="front/CSS/login.css" />
        <link rel="stylesheet" href="front/CSS/style.css" />
        <link rel="stylesheet" href="front/CSS/compte.css" />
        <script src="front/JS/verifChamp.js" defer></script>
    </head>

<body id="bodylogin">
        <header>
            <img src="front/images/logoLONGUEURBlanc.png" class="undraggable" />
        </header>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="back/dataNouveauMdp.php" method="post">
        <h1>Entrez votre nouveau mot de passe</h1>

        <label for="newMdp" id="labelNewMdp">
            Nouveau mot de passe :
        </label>
        <input type="password" id="psw" placeholder="Votre Mot de passe" name="newMdp" onchange="checkNewMdp()" required />
        <label id="labelVerifMdp" for="verifMdp">
            Confirmez le :
        </label>
        <input type="password" id="psw2" placeholder="Votre Mot de passe" name="verifMdp" onchange="checkSameMdp()" required />
        <button id="submitNewMdp" type="submit" class="btn" disabled='true' >Modifier</button>

    </form>
    
</body>
</html>
