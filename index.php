<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
$id = $_SESSION['id'];
$role = $_SESSION['role'];
if (!isset($_SESSION['darkMode'])) {
    $_SESSION["darkMode"] = false;
}
?>
<!DOCTYPE html>

<head>
    <title>LBR Drive - Galerie</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/css/alert.css" />
    <link rel="stylesheet" href="front/css/index.css" />
    <link rel="stylesheet" href="front/css/tag.css" />
    <link rel="icon" href="front/images/iconelbr.ico" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="front/js/alert.js" defer></script>
    <script src="front/js/masonry.js" defer></script>
    <script src="front/js/gallery.js" defer></script>
    <script src="front/js/side.js" defer></script>
</head>

<body>
    <?php
    include('header.php');
    ?>

    <div id="content">
        <div id="barre" class="undraggable">
            <div id="barre-scroll">
                <h1 class="barre-title">Selection multiple</h1>
                <div id="selection-multiple-toggle">Désactivé</div>
                <div id="selection-multiple">
                    <p><span id="selection-multiple-size">0 Octet</span> de fichiers selectionnés</p>
                    <?php if ($role == 'lecture') {
                    ?>
                        <div class="actionMultiple" onclick="downloadAll()"><img src="front/images/download.png" class="undraggable pointerOnHover"></div>
                    <?php
                    } else { ?>
                        <select class='pre-tri' id="selection-multiple-select">
                            <option value="" selected disabled>Tag</option>
                        </select>
                        <br>
                        <div id="actionSelect">
                            <div onclick="addTagAll()" class="pre-tri tout-type" id="selection-multiple-ajouter">
                                <p>Ajouter</p>
                            </div>
                            <div onclick="deleteTagAll()" class="pre-tri tout-type" id="selection-multiple-delete">
                                <p>Supprimer</p>
                            </div>
                        </div>
                        <div id="actionPrimaire">
                            <div class="actionMultiple" onclick="downloadAll()"><img src="front/images/download.png" class="undraggable pointerOnHover"></div>
                            <div class="actionMultiple" onclick="deleteAll()"><img src="front/images/delete.svg" class="undraggable pointerOnHover"></div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <h1 class="barre-title">Fonctions de tri</h1>
                <div id="tri-primaire">
                    <select class="pre-tri" id="select-utilisateur">
                        <option value="" default>Tous les utilisateurs</option>
                    </select>
                    <div class="pre-tri tout-type" id="toggle-type-fichier">
                        <p>Image / Vidéo</p>
                    </div>
                    <div class="pre-tri Intersection" id="toggle-type-tri-tag">
                        <p>Intersection</p>
                    </div>
                    <div class="pre-tri" id="toggle-mes-fichiers">
                        <p>Mes fichiers</p>
                    </div>
                    <div class="pre-tri" id="toggle-corbeille">
                        <p>Corbeille</p>
                    </div>
                </div>

                <h1 class="barre-title">Tri par tags</h1>
                <div id="liste-categories">
                    <!-- Ici s'appenderont les categories -->
                </div>
            </div>

            <?php if ($role != "lecture") { ?>
                <div id="espace-admin" class="undraggable">
                    <div id="espace-admin-title" class="pointerOnHover" onclick="$('#espace-admin').toggleClass('shown');">
                        <img src="front/images/arrow.png" class="undraggable">
                        <h3>Espace <?php if ($role == "invite") echo "invité";
                                    else echo $role ?></h3>
                    </div>
                    <div id="espace-admin-links">
                        <?php if ($role == "admin") { ?>
                            <a class="pointerOnHover undraggable" href="admin.php">Gestion des comptes</a>
                        <?php } ?>
                        <a class="pointerOnHover undraggable" href="tagManager.php">Gestion des tags/catégories</a>
                        <?php if ($role == "admin") { ?>
                            <a class="pointerOnHover undraggable" href="logs.php">Accéder aux logs</a>
                        <?php } ?>
                    </div>
                    <?php if ($role == "admin") {
                        function formatBytes($bytes, $precision = 2)
                        {
                            $units = array('Octets', 'Ko', 'Mo', 'Go', 'To');

                            $bytes = max($bytes, 0);
                            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                            $pow = min($pow, count($units) - 1);
                            $bytes /= pow(1024, $pow);
                            return round($bytes, $precision) . ' ' . $units[$pow];
                        }

                        function GetDirectorySize($path){
                            $bytestotal = 0;
                            $path = realpath($path);
                            if($path!==false && $path!='' && file_exists($path)){
                                foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                                    $bytestotal += $object->getSize();
                                }
                            }
                            return $bytestotal;
                        }

                        $espaceDisk = formatBytes(disk_free_space("/"), 0);
                        $espaceUpload = formatBytes(GetDirectorySize("upload/"), 0);

                        echo "<p id='storage'><img src='front/images/cloud.png' >Espace utilisé : " . $espaceUpload . " sur " . $espaceDisk .  " </p>";
                    } ?>
                </div>
            <?php } ?>

        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">

            </div>
        </div>
    </div>
</body>