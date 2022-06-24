<!DOCTYPE html>
<html lang="fr">

<head>
    <title>LBR Drive - Nouveau mot de passe</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/css/login.css" />
    <link rel="icon" href="front/images/iconelbr.ico"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/js/account/setPassword.js" defer></script>
</head>

<body id="bodylogin">

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form >
        <h1>Entrez votre nouveau mot de passe</h1>

        <label for="nouveauMdp" id="labelNouveauMdp">
            Nouveau mot de passe :
        </label>
        <input class='inputNouveauMdp' type="password" id="nouveauMdp" placeholder="1 maj/1 min/1 chiffre/1 caractère" name="nouveauMdp" onchange="VerifChampMdp()" required />
        <label for="verifNouveauMdp" id="labelVerifNouveauMdp" >
            Confirmez le :
        </label>
        <input class='inputNouveauMdp' type="password" id="verifNouveauMdp" placeholder="" name="verifNouveauMdp" onchange="idemMdp()" required />
        <button id="bouton" type="button" class="btn" onclick="submitNouveauMdp()" >Modifier</button>

    </form>

</body>

</html>