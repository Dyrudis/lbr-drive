<?php
    session_start();
    if($_SESSION['role']!='admin'){
        header('Location: index.php'); 
    }
?>
<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="front/CSS/admin.css" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="front/JS/admin.js" defer></script>
    <script src="front/JS/verifChamp.js" defer></script>
</head>

<body id="bodyadmin">

<?php
    include('header.php');
?>
    <div class="content">
        <div class="container">
                <div class="menu">
                    <h1> Espace Admin</h1>
                    <a href="#creation" class="btn-creation"><h2>Création d'un compte</h2></a>
                    <a href="#modif" class="btn-modif active"><h2>Modification de compte</h2></a>
                    <a href="#delete" class="btn-delete active"><h2>Supression de compte</h2></a>
                </div>
                
                <div class="creation">
                    <form class="contact-form" id="formCreationCompte">

                        <label>Prénom</label>
                        <input id="prenomCreationCompte" type="text" name="prenom" required>
                        
                        <label>Nom</label>
                        <input id="nomCreationCompte" type="text" name="nom" required>

                        <label>Mot de passe</label>
                        <input id="mdpCreationCompte" type="password" name="motdepasse" onblur="checkMdp()" required>
                        <label id="labelmdpInput" for="motdepasse">Mot de passe invalide</label>
                        
                        <div class="check">
                            <label>				
                                <input id="mdpTemporaire" class="checkbox" type="checkbox" name="mdpTemporaire" onchange="checkMdpTemporaire()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="23px" id="checkboite">
                                        <path class="path-back"  d="M1.5,6.021V2.451C1.5,2.009,1.646,1.5,2.3,1.5h18.4c0.442,0,0.8,0.358,0.8,0.801v18.398c0,0.442-0.357,0.801-0.8,0.801H2.3c-0.442,0-0.8-0.358-0.8-0.801V6"/>
                                        <path class="path-moving" d="M24.192,3.813L11.818,16.188L1.5,6.021V2.451C1.5,2.009,1.646,1.5,2.3,1.5h18.4c0.442,0,0.8,0.358,0.8,0.801v18.398c0,0.442-0.357,0.801-0.8,0.801H2.3c-0.442,0-0.8-0.358-0.8-0.801V6"/>
                                    </svg>
                            </label>
                            <h3 id="labelmdpTemp" for="mdpTemporaire">Utiliser un mot de passe temporaire</h3>
                        </div>

                        <label class="emailfix">Email</label>
                        <input id="emailCreationCompte" type="email" name="email" required>
                        
                        <label>Description</label>
                        <input id="descriptionCreationCompte" type="text" name="description" required>

                        <div class="box" id="box1">
                            <select id='selectRole' name="role" onchange="tagVisible()" required>
                                <option value="" disabled selected > Choix d'un role</option>
                                <option value="lecture">Lecture</option>
                                <option value="ecriture">Ecriture</option>
                                <option value="admin">Admin</option>
                                <option value="invite" >Invité</option>
                            </select>
                        </div>

                        <div id='tagInvite'>
                            <select id='boutonAddTag'>
                                <option value=""> +tag </option>
                            </select>
                        </div>
                        
                        <input type="button" class="submit" id="submitCreationCompte" value="Créer" onclick="submitInfoCompte()">
                        <input class="submit" id="mdpOublie" value="Renvoie de mail" href="reinitialiserMdp.php">
                    </form>
                    
                </div>
                
                <div class="modif active-section">
                    <form class="contact-form" action="back/suppCompte.php" method="post">
                        <label>Email du compte à modifier</label>
                        <input type="email" name="email">
                        
                        <div class="box" id="box2">
                            <select name="champ">
                              <option value=""> choix du champ à modifier </option>
                              <option value="Nom">Nom</option>
                              <option value="Prenom">Prenom</option>
                              <option value="Email">Email</option>
                              <option value="Role">Role</option>
                              <option value="MotDePasse">Mot de passe</option>
                            </select>
                        </div>
                        
                        <label>Nouvelle valeur</label>
                        <input type="text" name="valeur">
                                  
                        <input id= "positionModif" class="submit" type="submit" value="Modifier" name="submit">	
                    </form>
                </div>

                <div class="delete delete-section">
                    <div class="contact-form" action="back/suppCompte.php" method="post">
                        <label>Email du compte à supprimer</label>
                        <input  type="email" name="email">
                        
                        <label for="mdpCompte">Veuillez entrer votre mot de passe</label>
                        <input type="password" name="mdpCompte">
                                  
                        <input class="submit" id="btn-suppr" type="submit" value="Supprimer" name="submit">	
                            
                    </div>
                </div>
                
        </div>
    
    </div>
</body> 
</html>
