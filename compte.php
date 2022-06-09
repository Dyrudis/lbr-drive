<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');

if ($_SESSION['id']) {
    $id = $_SESSION['id'];
} else {
    header("Location: login.php");
}

$sql = "SELECT * FROM utilisateur WHERE IDUtilisateur = '$id' ";
$result = $mysqli->query($sql);

$infoUtilisateur = $result->fetch_all(MYSQLI_ASSOC);
foreach ($infoUtilisateur as $info) {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/JS/compte.js" defer></script>
    <script src="front/JS/requeteAjax/requeteModifMdp.js" defer></script>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div id="main">
        <div id="title">
            <div id="avatar-container">
                <img class='undraggable' <?php
                                            // Check if file exist
                                            if (file_exists("avatars/$id")) {
                                                echo "src='avatars/$id'";
                                            } else {
                                                echo "src='avatars/default.jpg'";
                                            }
                                            ?> alt="avatar" id="avatar" />
                                            <p>Modifier</p>
            </div>
            <div id="title-content">
                <div id="title-content-up">
                    <h1>Mon compte</h1>
                    <?php
                    echo "<p class='tag undraggable' id='role-compte'>" . $role . "</p>";
                    ?>
                </div>
                <p>Modifiez votre photo et vos données personnelles</p>
            </div>

        </div>

        <div id="info">
            <div id="info-prenom">
                <h3>Prénom</h3>
                <?php
                echo "<p>" . $prenom . "</p>";
                ?>
            </div>
            <div id="info-nom">
                <h3>Nom</h3>
                <?php
                echo "<p>" . $nom . "</p>";
                ?>
            </div>
            <div id="info-desc">
                <h3>Description</h3>
                <?php
                echo "<p>" . $description . "</p>";
                ?>
            </div>
            <div id="info-email">
                <h3>Email</h3>
                <?php
                echo "<p>" . $email . "</p>";
                ?>
            </div>

        </div>

        <div class="open-btn">
            <button class="open-button" onclick="openForm()"><strong>Modifier son mot de passe</strong></button>
        </div>
        <div class="form-popup" id="popupForm">
            <form action="back/modifMdp.php" method="post" class="form-container">
                <label for="ancienMdp">
                    <strong> Votre ancien mot de passe :</strong>
                </label>
                <input class='inputNouveauMdp' type="password" id="ancienMdp" placeholder="Ancien mot de passe" name="ancienMdp" required />

                <label for="nouveauMdp" id="labelNouveauMdp">
                    Nouveau mot de passe :
                </label>
                <input class='inputNouveauMdp' type="password" id="nouveauMdp" placeholder="1 maj/1 min/1 chiffre/1 caractère" name="nouveauMdp" onchange="VerifChampMdp()" required />
                <label for="verifNouveauMdp" id="labelVerifNouveauMdp" >
                    Confirmez le :
                </label>
                <input class='inputNouveauMdp' type="password" id="verifNouveauMdp" placeholder="" name="verifNouveauMdp" onchange="idemMdp()" required />
                <button id="bouton" type="button" class="btn" onclick="submitNouveauMdp()" >Modifier</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Fermer</button>
            </form>
        </div>
        <script>
            function openForm() {
                document.getElementById("popupForm").style.display = "block";
            }

            function closeForm() {
                document.getElementById("popupForm").style.display = "none";
            }
        </script>

    </div>

</body>

</html>