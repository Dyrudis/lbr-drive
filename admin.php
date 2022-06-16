<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
}
$id = $_SESSION['id'];
$role = $_SESSION['role'];

if ($role != 'admin') {
    header('Location: index.php');
}
?>
<!DOCTYPE html>

<html>

<head>
    <title>Gestion des comptes</title>
    <link rel="stylesheet" href="front/css/alert.css" />
    <link rel="stylesheet" href="front/css/admin.css" />
    <link rel="icon" href="front/images/iconelbr.ico"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/js/admin.js" defer></script>
    <script src="front/js/alert.js" defer></script>
    <script src="front/js/account/checkFields.js" defer></script>
    <script src="front/js/account/deleteAccount.js" defer></script>
</head>

<body id="bodyadmin">

    <?php
    include('header.php');
    ?>
    <div class="content">

        <form id="formCreationCompte">
            <h2>Création de compte</h2>
            <label>Prénom</label>
            <input class="inputCreationCompte" id="prenomCreationCompte" type="text" name="prenom" required>

            <label>Nom</label>
            <input class="inputCreationCompte" id="nomCreationCompte" type="text" name="nom" required>

            <label>Mot de passe</label>
            <input class="inputCreationCompte" id="mdpCreationCompte" type="password" name="motdepasse" onblur="checkMdp()" required>
            <label id="labelmdpInput" for="motdepasse">Mot de passe invalide</label>

            <div class="check">
                <label>
                    <input id="mdpTemporaire" class="checkbox" type="checkbox" name="mdpTemporaire" onchange="checkMdpTemporaire()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="23px" id="checkboite">
                        <path class="path-back" d="M1.5,6.021V2.451C1.5,2.009,1.646,1.5,2.3,1.5h18.4c0.442,0,0.8,0.358,0.8,0.801v18.398c0,0.442-0.357,0.801-0.8,0.801H2.3c-0.442,0-0.8-0.358-0.8-0.801V6" />
                        <path class="path-moving" d="M24.192,3.813L11.818,16.188L1.5,6.021V2.451C1.5,2.009,1.646,1.5,2.3,1.5h18.4c0.442,0,0.8,0.358,0.8,0.801v18.398c0,0.442-0.357,0.801-0.8,0.801H2.3c-0.442,0-0.8-0.358-0.8-0.801V6" />
                    </svg>
                </label>
                <h3 id="labelmdpTemp" for="mdpTemporaire">Utiliser un mot de passe temporaire</h3>
            </div>

            <label class="emailfix">Email</label>
            <input class="inputCreationCompte" id="emailCreationCompte" type="email" name="email" required>

            <label>Description</label>
            <input class="inputCreationCompte" id="descriptionCreationCompte" type="text" name="description" required>

            <select class="inputCreationCompte" id='selectRole' name="role" onchange="tagVisible()" required>
                <option value="" disabled selected> Choix d'un role</option>
                <option value="lecture">Lecture</option>
                <option value="ecriture">Ecriture</option>
                <option value="admin">Admin</option>
                <option value="invite">Invité</option>
            </select>

            <div id='tagInvite'>
                <select id='boutonAddTag'>
                    <option value="">+ Tag</option>
                </select>
            </div>

            <input type="button" class="submit" id="submitCreationCompte" value="Créer" onclick="submitInfoCompte()">
            <input class="submit" id="mdpOublie" value="Renvoie de mail" href="reinitialiserMdp.php">
        </form>
        <form id="formModifCompte">

            <h2>Modification de compte</h2>
            <label>Email du compte à modifier</label>
            <input class="inputModifCompte" id="emailModifCompte" type="email" name="email">

            <select class="inputModifCompte" id="selectChamp" name="champ" onchange="modifTagInvite()">
                <option value="" disabled selected>Champ à modifier</option>
                <option value="Nom">Nom</option>
                <option value="Prenom">Prenom</option>
                <option value="Email">Email</option>
                <option value="Role">Role</option>
                <option value="MotDePasse">Mot de passe</option>
                <option value="tag">Tag visible</option>
            </select>

            <div id='tagInvite2'>
                <select id='boutonAddTagInvite'>
                    <option value="">+ Tag</option>
                </select>
            </div>

            <label id='labelNouvelleValeur'>Nouvelle valeur</label>
            <input class="inputModifCompte" id='nouvelleValeur' type="text" name="valeur">

            <input id="positionModif" class="submit" type="button" value="Modifier" onclick="submitModifCompte()">
        </form>
        <form id="formSupprCompte">

            <h2>Suppression de compte</h2>
            <label for="emailSuppr">Email du compte à supprimer</label>
            <input class="inputSupprCompte" id='emailCompteSuppr' type="email" name="emailSuppr">

            <label for="mdpCompte">Veuillez entrer votre mot de passe</label>
            <input class="inputSupprCompte" id='motDePasse' type="password" name="mdpCompte">

            <input class="submit" id="btn-suppr" type="button" value="Supprimer" name="submit" onclick="submitSupprCompte()">

        </form>
    </div>
</body>

</html>