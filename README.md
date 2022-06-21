
# Drive - Les briques rouges

<p align="center">
  <img src="front\images\logoLONGUEURBlanc.png" alt="Logo - Les briques rouges" width="600" />
</p>

Ce projet est un drive privé hébergé par un site internet en ligne et dédié au festival "Les briques rouges". Il a été développé par 4 étudiants en CIR3 à l'ISEN Lille.

# Installation

1. Pour commencer à utiliser ce drive, vous devez placer les fichiers sur un serveur (en local avec [WampServer](https://www.wampserver.com/) par exemple, ou en ligne).

2. Il faut également que vous configuriez une base de données en éxécutant le fichier [`lbr_drive.sql`](https://github.com/Dyrudis/lbr-drive/blob/main/lbr_drive.sql) sur une nouvelle table.

3. Enfin, vous devez modifier le contenu du fichier [`back/database.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/database.php) à la ligne 8 avec les informations de connexion à votre base de données.

    ```php
    $mysqli = new mysqli('localhost', 'root', '', 'lbr_drive');
    ```

Et voilà, c'est prêt ! Il ne vous reste plus qu'à vous rendre sur votre navigateur à l'adresse de votre serveur. Vous pouvez vous connecter avec l'un des quatre comptes de test fournis dans le fichier [`lbr_drive.sql`](https://github.com/Dyrudis/lbr-drive/blob/main/lbr_drive.sql) :
|Rôle|Email|Mot de passe|
|--|--|--|
|Admin|a@a|test|
|Ecriture|e@e|test|
|Invité|i@i|test|
|Lecture|l@l|test|

# Utilisation

## Parcourir la galerie

La galerie, page centrale du site, centralise tous les fichiers, leur affichage ainsi que leur manipulation.

On y retrouve deux parties :

- ### La sidebar d'action et de tri

  Située sur la gauche, elle permet plusieurs actions :
  - La **Sélection multiple** permet, après activation, de sélectionner plusieurs fichiers par un simple clic gauche dans la gallerie.

    On peut alors effectuer les actions suivante :
    - Ajouter à la sélection un tag aux vidéos ne l'ayant pas déjà.
    - Supprimer un tag aux vidéos ayant le tag en question.
    - Télécharger les fichiers de la sélection.
    - Envoyer dans la corbeille toute la sélection.

  - Les **Fonctions de tri**, qui permettent l'activation de 4 trieurs spécifiques :

    - *Mes fichiers* qui, sur la galerie, n'autorisera l'apparition que des fichiers uploadés dans la base de données par l'utilisateur en question.
    - *Corbeille* qui passera l'affichage des fichiers de la galerie à ceux dans la corbeille.
    - Le tri par *Type de fichier*, (par défaut sur Image / Vidéo), permet par modes l'affichage des Images et/ou Vidéos.
    - Le *Type de filtrage par tag*, (par défaut sur Intersection), qui modifiera le comportement du tri par tags en alternant entre Intersection et Union :
      - Le mode Intersection cherchera à afficher les fichiers comportant au moins tous les tags sélectionnés ( Il faut que soit associé à chaque fichier le tag *a* ET *b* etc... ).
      - Le mode Union, lui, autorisera l'apparition de tout fichier ayant au moins un des tag du tri par tag (Il faut que soit associé à chaque fichier le tag *a* OU *b* etc... ).  

  - Le **Tri par tags**, filtrant l'affichage des fichiers selon une sélection de tags appartenant à des catégories :

    Ce mode de tri principal permet à l'utilisateur de ne laisser apparaître que le fichiers en concordance avec son *Type de filtrage par tag* ainsi que sa sélection de tags, eux-mêmes triés par catégories :

    Chaque tag appartient à une catégorie créée au préalable. Qu'il s'agisse de la catégorie "Autres" par défaut ou "Edition" si elle est créée, ces catégories contiennent des tags qui, si ils sont sélectionnés, affecteront les fichiers apparant.

- ### La galerie elle-même

Comme vu précedemment, la galerie contient les fichiers qui concordent avec le tri effectué.  
Selon la taille de l'appareil utilisé, le nombre de fichiers visibles ainsi que leurs tailles variera pour le meilleur.  
Ca n'est cependant pas tout, la galerie est en réalité bien plus qu'un simple menu d'affichage puisqu'elle permet bien des actions :

- **Affichage en plein écran** :  
  Par un simple clique gauche, qu'il s'agisse d'une image ou d'une vidéo, celle-ci passera en plein écran.  

- **Affichage des tags et propriétés du fichier** :  
  D'un simple passage de la souris sur l'élément dérouleront les infos du fichier :  
  - Son titre : affiché en gras au milieu du menu déroulé.
  - Ses tags : sous forme de tags aux couleurs de leurs catégories.
  - L'utilisateur source : La personne qui a uploadé le fichier dont il est question.
  - La date d'upload : La date du jour où fut uploadé le fichier.
  - La taille du fichier : L'espace prit par ce dernier sur le disque serveur.
  - Sa durée : s'il s'agit d'une vidéo seulement, sa durée en minute.

- **Action sur les fichiers** :  
  Lors d'un clique droit sur un fichier, son menu déroulant se développe de manière à laisser apparaitre quelques options :  
  - Supprimer des tags :  
    A côté de chaque tag apparaitra une petite croix sur laquelle il est possible de cliquer pour supprimer du fichier le tag visé  (Pas de demande de confirmation). Il n'est cependant pas possible de supprimer *Sans tag* qui apparait dans le cas où tous les tags sont supprimés ou si le fichier n'en avait pas au préalable.
  - Editer le titre :  
    En cliquant sur le petit crayon apparaissant sur la droite du titre, il devient possible de modifier ce dernier au clavier.  
  - Télécharger le fichier :  
    En cliquant sur le symbole de téléchargement, le fichier est téléchargé sur votre appareil.  
  - Envoyer le fichier dans la corbeille :  
    L'icone de la poubelle déplacera, une fois cliquée, le fichier correspondant dans la corbeille. Après quoi ce dernier sera définitivement supprimé au bout de 30 jours.  
  - Ajouter des tags :  
    Le tag spécial "+ Tag" permet d'ouvrir un menu déroulant via lequel il est possible d'ajouter au fichier les tags souhaités.

## Ajouter vos fichiers

**TODO** : Compléter cette section

## Modifier des fichiers

**TODO** : Compléter cette section

## Modifier des tags et catégories

**TODO** : Compléter cette section

## Créer, modifier et supprimer des comptes

**TODO** : Compléter cette section

## Parcourir les logs

**TODO** : Compléter cette section

## Modifier son mot de passe et son avatar

**TODO** : Compléter cette section

# Documentation

## Back

- Dossier `back/file` :  
  Ce dossier comporte 8 fichiers qui permettent d'ajouter, de modifier et de supprimer des fichiers sur le drive :
  - [`addTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/addTag.php)
    - Ajoute le tag dont l'id est `IDTag` au fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
        url: "back/file/addTag.php",
        data: { IDTag: 2, IDFichier: "QnzwFjvw5z" },
        success: (res) => console.log(res),
      });
      ```

  - [`deleteFile.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/deleteFile.php)
    - Supprime définitivement de la BDD et du disque un fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/deleteFile.php",
          data: { IDFichier: "QnzwFjvw5z" },
          success: (res) => console.log(res), 
      });
      ```

- Dossier `back/tag` :  
  Ce dossier comporte 8 fichiers qui permettent de créer, modifier et supprimer des tags et des catégories sur le drive :
  - [`createCategory.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/createCategory.php)
    - Crée une catégorie dont le nom est `name` et la couleur est `color`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/createCategory.php",
          data: { name: "Genre", color: "A48FCD" },
          success: (res) => console.log(res),
      });
      ```

  - [`createTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/createTag.php)
    - Crée un tag dont le nom est `name` qui appartient à la catégorie dont l'id est `IDCategorie`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/createTag.php",
          data: { name: "Rock", IDCategorie: 3 },
          success: (res) => console.log(res),
      });
      ```

## Front

**TODO** : Compléter cette section
