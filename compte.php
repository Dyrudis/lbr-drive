<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'testb');
$id = $_SESSION['id'];
$sql = "SELECT * FROM utilisateur WHERE idUtilisateur = '$id' ";
$result = $mysqli->query($sql);
$infoUtilisateur = $result->fetch_all(MYSQLI_ASSOC);
foreach($infoUtilisateur as $info){
    $prenom = $info["prenom"];
    $nom = $info["nom"];
    $description = $info["description"];
    $email = $info["email"];
    $role = $info["role"];
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
            <a id="lienHome" href="index.html">Home</a>
            <img src="front/images/logoLONGUEURBlanc.png" />
            <p id="compte">Mon compte</p>
            
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
                <button onclick="window.location.href = 'index.html'">Accéder à la galerie</button>
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
                <button onclick="window.location.href = 'upload.js'">Dépot de fichier</button>
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
                <input type="password" name="motdepasse" placeholder="motdepasse" required >
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
            </div>
        <?php
            }
        ?>
        <?php
            if($role=="invite"){
        ?>
            <div id="main2">
                <h1>Espace invité :</h1>
                
            </div>
        <?php
            }
        ?>
    </body>
</html>