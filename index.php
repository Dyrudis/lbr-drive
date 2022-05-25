<?php
session_start();
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<head>
    <title>Espace de stockage</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="front/CSS/style.css" />
</head>

<body>
    <header>
        <p id="home" class="pointerOnHover">Home</p>
        <a id="lienUpload" href="addfile.php"> Upload un fichier</a>
        <img src="front/images/logoLONGUEURBlanc.png" />
        <?php
        if($id!=''){
        ?>
        <a id="lienCompte" href="compte.php">Mon compte</a>
        <?php
        }
        else{
            ?>
        <a id="lienCompte" href="login.php">Connection</a>
        <?php
            }
        ?>
        

    </header>

    <div id="content">
        <div id="barre">
            <div>
                Filtrer par tag
                <p id="lineunderfilter"> </p>
            </div>
            <div class="list-tags">
                <div class="category">
                    <p id="title-tag">Année</p>
                    <div id="taglist"></div>
                </div>
                <div class="category">
                    <p id="title-tag">Type de fichier</p>
                    <div id="taglist"></div>
                </div>
                <div class="category">
                    <p id="title-tag">Autres</p>
                    <div id="taglist"></div>
                </div>

                <div class="category">
                    <p id="title-tag">Ce que tu veux</p>
                    <div id="taglist"></div>
                </div>

                <div class="category">
                    <p id="title-tag">Créer une catégorie</p>
                    <div id="taglist"></div>
                </div>
            </div>
        </div>

        <div id="gallery-container">
            <div id="gallery-header"></div>
            <div id="gallery">
                <div id="col-1">
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1080" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://cdn.discordapp.com/attachments/973959663517331508/976596110346952775/IMG_0643.jpg" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/600" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                </div>
                <div id="col-2">
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1120" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1202" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                </div>
                <div id="col-3">
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/602" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1200" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1000" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                </div>
                <div id="col-4">
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/800" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1088" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                    <div class="file-container">
                        <img src="https://picsum.photos/1920/1300" alt="Photo de test" />
                        <div class="file-hover">
                            <div class="file-hover-tags">
                                <div class="tag">
                                    <p>2022</p>
                                </div>
                                <div class="tag">
                                    <p>Photo</p>
                                </div>
                                <div class="tag">
                                    <p>Tag random</p>
                                </div>
                            </div>
                            <h2 class="file-hover-title">Des gens s'amusent à un concert</h2>
                            <p class="file-hover-author">de Tanguy Singeot-Sousa, le 23/05/22</p>
                            <p class="file-hover-info">516Mo - 2:03</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
