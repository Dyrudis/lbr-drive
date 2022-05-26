<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');
$id = $_SESSION['id'];
$sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id' ";
$result = $mysqli->query($sql);
$infoUtilisateur = $result->fetch_all(MYSQLI_ASSOC);
foreach($infoUtilisateur as $info){
    $prenom = $info["Prenom"];
    $nom = $info["Nom"];
    $description = $info["Description"];
    $email = $info["Email"];
    $role = $info["Role"];
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Mon compte</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="front/CSS/compte.css" />
        <link rel="stylesheet" href="front/CSS/style.css" />
    </head>

    <body>
        <header>
            <a id="lienHome" href="index.php">Home</a>
            <img src="front/images/logoLONGUEURBlanc.png" />
            <a id="compte" href="back/logOut.php">deconnection</a>
            
        </header>

        <div id="main">
            <h1>Mon Espace</h1>
            <div id="RoleCompte">
                <p> Rôle </p>
            </div>
            <img src="https://cdn.discordapp.com/attachments/653297075550814208/978235793090953236/unknown.png" id="pp">
            <?php
                echo"<p id='prenom'> <b> Prémon : </b> " . $prenom . "</p>";
                echo"<p id='nom'> <b> Nom : </b>  " . $nom . "</p>";
                echo"<p id='description'> <b> Description : </b><br> &emsp;  " . $description . " </p>";
                echo"<p id='email'> <b> Adresse mail : </b>  " . $email . "</p>";
            ?>
                <input class='bouton' type='button' value='Modifier le profil'>;
                <p id='mesfichiers'> <b> Mes fichiers </b></p>;

        </div>
        <?php
            if($role=="lecture"){
        ?>
            <div id="main2">
                <h1>Espace lecteur :</h1>
                <p>Votre role vous permet d'accéder à tous les fichiers déposer sur notre drive.</p>
                <button onclick="window.location.href = 'index.php'">Accéder à la galerie</button>
            </div>
        <?php
            }
        ?>
        <?php
            if($role=="ecriture"){
        ?>
            <div id="main2">
                <h1>Espace ecriture :</h1>
                <p>
                    Votre role vous permet d'en plus d'accéder à la galerie (page home), de créer des tags/ catégorie de tag ou encore importer
                    des fichiers sur le drive. 
                </p>
                <button onclick="window.location.href = '/front/JS/upload.js'">Dépot de fichier</button>
            </div>
        <?php
            }
        ?>
        <?php
            if($role=="admin"){
        ?>
            <div id="main2">
                <h1>Espace admin :</h1>
                <h2>Création d'un compte :</h2>
                <form action="back/dataSignUp.php" method="post">
                    <input type="text" name="prenom" placeholder="prenom" required>
                    <input type="text" name="nom" placeholder="nom" required >
                    <br>
                    <input type="password" name="motdepasse" placeholder="motdepasse" >
                    <input type="checkbox" name="mdpTemporaire" >
                    <label id="labelmdp"for="mdpTemporaire">Utiliser un mot de passe temporaire</label>
                    <br>
                    <input type="email" name="email" placeholder="email">
                    <input type="text" name="description" placeholder="description">
                    <select name="role">
                        <option value="">--choix d'un role--</option>
                        <option value="lecture">lecture</option>
                        <option value="ecriturre">ecriture</option>
                        <option value="admin">admin</option>
                        <option value="invite">invite</option>
                    </select>

                    <input type="submit" value="Créer" name="submit">
                </form>
                <h2>modification d'un compte :</h2>
                <form action="back/modifCompte.php" method="post">
                    <input type="email" name="email" placeholder="email du compte à modifier">
                    <br>
                    <select name="champ">
                        <option value="">--choix du champ à modifier--</option>
                        <option value="Nom">Nom</option>
                        <option value="Prenom">Prenom</option>
                        <option value="Email">Email</option>
                        <option value="Role">Role</option>
                        <option value="MotDePasse">Mot de passe</option>
                    </select>
                    <input type="text" name="valeur" placeholder="nouvelle valeur">

                    <input type="submit" value="modifier" name="submit">
                </form>
                <h2>suppression d'un compte :</h2>
                <form action="back/suppCompte.php" method="post">
                    <input type="email" name="email" placeholder="email du compte à supprimer">
                    <br>
                    <label for="mdpCompte">Veuillez entrer votre mot de passe :</label>
                    <input type="password" name="mdpCompte" placeholder="mot de passe">

                    <input type="submit" value="supprimer" name="submit">
                </form>
            </div>
        <?php
            }
        ?>
        <?php
            if($role=="invite"){
        ?>
            <div id="main2">
                <h1>Espace invité :</h1>
                <p></p>
                
            </div>
        <?php
            }
        ?>
    </body>
</html>