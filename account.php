<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
}
$id = $_SESSION['id'];
$role = $_SESSION['role'];

include('back/database.php');

$result = query("SELECT * FROM utilisateur WHERE IDUtilisateur = ?", "i", $id);

$prenom = $result[0]["Prenom"];
$nom = $result[0]["Nom"];
$description = $result[0]["Description"];
$email = $result[0]["Email"];
$role = $result[0]["Role"];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>LBR Drive - Mon compte</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/css/alert.css" />
    <link rel="stylesheet" href="front/css/account.css" />
    <link rel="stylesheet" href="front/css/tag.css" />
    <link rel="stylesheet" href="front/css/alert.css" />
    <link rel="icon" href="front/images/iconelbr.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/js/alert.js" defer></script>
    <script src="front/js/account/updateAvatar.js" defer></script>
    <script src="front/js/account/updatePassword.js" defer></script>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div id="main">
        <div id="title">
            <div id="avatar-container">
                <img class='undraggable' <?php echo "src='avatars/$id'"; ?> alt="avatar" id="avatar" />
                <p id="popupmodif">Modifier</p>
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

        <button class="open-button" onclick="openForm()"><strong>Modifier son mot de passe</strong></button>
        <?php
        if ($_SESSION['darkMode'] == true) {
        ?>
            <button class="open-button" id="colormod" onclick="changeMode();">Thème clair</button>
        <?php
        } else {
        ?>
            <button class="open-button" id="colormod" onclick="changeMode();">Thème sombre</button>
        <?php
        }
        ?>

        <div class="form-popup" id="popupForm">
            <form class="form-container">
                <label for="ancienMdp">
                    <strong> Ancien mot de passe :</strong>
                </label>
                <input class='inputNouveauMdp' type="password" id="ancienMdp" placeholder="Ancien mot de passe" name="ancienMdp" required />

                <strong for="nouveauMdp" id="labelNouveauMdp">
                    Nouveau mot de passe :
                </strong>
                <input class='inputNouveauMdp' type="password" id="nouveauMdp" placeholder="1 maj/1 min/1 chiffre/1 caractère" name="nouveauMdp" onchange="VerifChampMdp()" required />
                <strong for="verifNouveauMdp" id="labelVerifNouveauMdp">
                    Confirmez mot de passe :
                </strong>
                <input class='inputNouveauMdp' type="password" id="verifNouveauMdp" placeholder="" name="verifNouveauMdp" onchange="idemMdp()" required />
                <button id="bouton" type="button" class="btn" onclick="submitNouveauMdp()">Modifier</button>
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

            function changeMode() {

                $.ajax({
                    type: "POST",
                    url: "back/account/updateDarkMode.php",
                    data: {},
                    success: (data) => {
                        if (data == "theme sombre") {
                            document.documentElement.style.setProperty('--colorBackground', '#161619');
                            document.documentElement.style.setProperty('--colorText', '#FFFFFF');
                            document.documentElement.style.setProperty('--colorBox', 'rgb(16, 0, 16)');
                            document.documentElement.style.setProperty('--colorInput', 'white');
                            document.documentElement.style.setProperty('--colorLabelInput', 'black');
                            document.getElementById('colormod').textContent = "Thème clair";
                            alert.create({
                                content: "Theme sombre appliqué",
                                type: "success",
                            });
                        } else {
                            document.documentElement.style.setProperty('--colorBackground', '#FFFee6');
                            document.documentElement.style.setProperty('--colorText', '#161619');
                            document.documentElement.style.setProperty('--colorBox', 'rgba(222, 222, 222, 1)');
                            document.documentElement.style.setProperty('--colorInput', 'black');
                            document.documentElement.style.setProperty('--colorLabelInput', 'white');
                            document.getElementById('colormod').textContent = "Thème sombre";
                            alert.create({
                                content: "Theme clair appliqué",
                                type: "success",
                            });
                        }

                    },
                });


            }
        </script>

    </div>

</body>

</html>