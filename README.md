
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

Comme il est possible de le voir ci-dessus : il existe plusieurs "roles".  
Chacun d'entre eux à ses particularités :  
  
- **Administrateur** : Peut tout faire, jusqu'à créer les comptes d'autres utilisateurs, les modifier ou supprimer, voir les logs etc...  

- **Ecriture** : Peut, tout comme un administrateur, uploader des fichiers, modifier tout fichier existant ou le supprimer. Créer des tags et catégories etc...  

- **Lecture** : N'a accès qu'à la galerie et à son compte. Ne peut upload de fichiers, en modifier, supprimer. Il en va de même pour les tags ainsi que les catégories.  

- **Invité** : Est un lecteur qui a les droits d'écriture pour des tags/catégories prédéfinies par un administrateur lors de la création de son compte.

Concernant la création d'un compte, le champ email entré par l'administrateur est utilisé pour que la personne concernée recoive un email contenant son mot de passe temporaire. Il permettra également d'ouvrir directement la page de login du site puis suggérera à ce dernier de changer son mot de passe tout en respectant les normes de solidité pour plus de sécurité.

# Utilisation

## Parcourir la galerie

La galerie, page principale du site, centralise tous les fichiers, leur affichage ainsi que leur manipulation.

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
    A côté de chaque tag apparaitra une petite croix sur laquelle il est possible de cliquer pour supprimer du fichier le tag visé. Il n'est cependant pas possible de supprimer *Sans tag* qui apparait dans le cas où tous les tags sont supprimés ou si le fichier n'en avait pas au préalable.

  - Editer le titre :  
    En cliquant sur le petit crayon apparaissant sur la droite du titre, il devient possible de modifier ce dernier au clavier.  

  - Télécharger le fichier :  
    En cliquant sur le symbole de téléchargement, le fichier est téléchargé sur votre appareil.  

  - Envoyer le fichier dans la corbeille :  
    L'icone de la poubelle déplacera, une fois la demande de confirmation validée, le fichier correspondant dans la corbeille. Après quoi ce dernier sera définitivement supprimé au bout de 30 jours.  

  - Ajouter des tags :  
    Le tag spécial "+ Tag" permet d'ouvrir un menu déroulant via lequel il est possible d'ajouter au fichier les tags souhaités.  
  
- **Corbeille** :  
  Comme mentionné précédemment il existe une corbeille dans laquelle sont donc envoyés les fichiers souhaités.  
  Cette corbeille fait partie elle aussi de la galerie, étant accessible depuis la sidebar dans les fonctions de tri, et comme son nom l'indique : affiche les éléments dans la corbeille.

  Quant à ce qu'il est possible d'y faire :

  - Voir pour chaque fichier (toujours en mettant la souris dessus) le temps restant avant suppression automatique.

  - Restaurer le fichier d'un simple clique sur l'icone correspondante.

  - Supprimer manuellement un fichier de manière définitive.

## Ajouter vos fichiers

Le menu d'upload d'images et vidéos voit sa propore page lui être allouée.  
En effet, accessible depuis le header si l'utilisateur en a le droit, il est possible de cliquer sur l'onglet "Ajouter un fichier".  
Une fois chose faite, l'utilisateur arrive sur une page presque vierge où, de manière intuitive, lui est décrit la marche à suivre afin de mettre en ligne les fichiers souhaités.  
Pour ce faire il peut :  

- Cliquer sur le bouton "Ajouter" qui lui ouvrira l'explorateur de fichier depuis lequel il pourra ouvrir un ou plusieurs fichiers.  

- Click & Drag directement depuis un explorateur de fichier déjà ouvert les fichiers souhaités.

Une fois ceci fait l'utilisateur peut alors modifier ce qu'il souhaite et préparer les fichiers pour qu'ils soient déjà complétés lors de leur envoie. Pour ce faire il peut :  

- Modifier le titre du fichier.

- Ajouter des tags au fichier.

- Sélectionner une miniature s'il s'agit d'une vidéo en positionnant cette derniere au moment souhaité.

Une fois le début de l'upload initié il est possible de suivre l'avancement fichier par fichier de l'upload via une barre de chargement retraçant en direct l'avancée pour chacun d'eux.

## Modifier des tags et catégories

Une page est allouée à la modificat...

## Créer, modifier et supprimer des comptes

**TODO** : Compléter cette section

## Parcourir les logs

**TODO** : Compléter cette section

## Modifier son mot de passe et son avatar

**TODO** : Compléter cette section

# Documentation

## Back

- [`database.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/database.php)
  - Contient les informations de connexion à la base de donnée, ainsi qu'une fonction `query` qui permet d'effectuer des requêtes SQL sécurisées (prepared statement). Ce fichier est donc importé dans la plupart des fichiers du back.
  - Exemple d'utilisation :
  
    ```php
    $result = query("SELECT * FROM x WHERE y = ?", "i", $var);

    // $result est de la forme [{"a": 0, "b": 1}, {"a": 2, "b": 3}, ...]
    // Le nombre de lignes renvoyées est donc calculé avec count($result)
    ```

- Dossier `back/file` :  
  Ce dossier comporte 8 fichiers qui permettent d'ajouter, modifier et supprimer des fichiers sur le drive :
  - [`addTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/addTag.php)
    - Ajoute le tag dont l'id est `IDTag` au fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/addTag.php",
          data: { IDFichier: "QnzwFjvw5z", IDTag: 2 },
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

  - [`deleteTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/deleteTag.php)
    - Supprime le tag dont l'id est `IDTag` du fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/deleteTag.php",
          data: { IDFichier: "QnzwFjvw5z", IDTag: 2 },
          success: (res) => console.log(res),
      });
      ```

  - [`getFiles.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/getFiles.php)
    - Permet de récupérer la liste des fichiers qui correspondent aux critères de selections envoyés en paramètre :
      - `user` : un booléen qui, lorsqu'il vaut `true`, permet de ne retourner que les fichiers qui appartiennent à la personne qui fait la requête.
      - `tags` : un tableau d'id de tags pour trier les fichiers retournés.
      - `typeTriTag` : un booléen qui, lorsqu'il vaut `true`, permet de ne retourner que les fichiers qui possèdent tous les tags présents dans le tableau `tags` (intersection). Sinon, tous les fichiers qui possèdent au moins l'un des tags présents dans le tableau `tags` seront retournés (union).
      - `corbeille` : un booléen qui, lorsqu'il vaut `true`, permet de ne retourner que les fichiers qui sont dans la corbeille.
      - `fileType` : une chaine de caractères qui permet de ne retourner que les fichiers qui sont du type demandé ("image", "video", sinon les deux).
    - Retourne la liste des fichiers qui correspondent aux critères de selections sous forme de chaine de caractères JSON.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/getFiles.php",
          data: {
              user: true,
              tags: JSON.stringify([2, 6, 7]),
              typeTriTag: true,
              corbeille: false,
              fileType: "image/video",
          },
          success: (res) => console.log(JSON.parse(res)),
      });
      ```

  - [`restoreFile.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/restoreFile.php)
    - Restaure de la corbeille le fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/restoreFile.php",
          data: { IDFichier: "QnzwFjvw5z" },
          success: (res) => console.log(res),
      });
      ```

  - [`suspendFile.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/suspendFile.php)
    - Met à la corbeille le fichier dont l'id est `IDFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/suspendFile.php",
          data: { IDFichier: "QnzwFjvw5z" },
          success: (res) => console.log(res),
      });
      ```

  - [`updateTitle.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/updateTitle.php)
    - Mofifie le nom du fichier dont l'id est `IDFichier` en `NomFichier`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/updateTitle.php",
          data: { IDFichier: "QnzwFjvw5z", NomFichier: "Nouveau nom" },
          success: (res) => console.log(res),
      });
      ```

  - [`uploadFile.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/file/uploadFile.php)
    - Ajoute le chunk (une partie du fichier) envoyé dans le dossier `upload/chunks`. Si tous les chunks ont été envoyés, le fichier est fusionné et déplacé dans le dossier `upload` :
      - `file` : le chunk du fichier.
      - `currentChunkNumber` : le numéro du chunk.
      - `totalChunkNumber` : le nombre total de chunks.
      - `extension` : l'extension du fichier.
      - `timestamp` : le timestamp en secondes de la miniature affichée dans la galerie de la vidéo (si c'est une vidéo).
      - `name` : le nom du fichier.
      - `duration` : la durée de la vidéo en secondes (si c'est une vidéo).
      - `tags` : le tableau des tags associés au fichier.
    - Retourne `"Chunk received"` si le chunk à bien été reçu, ou `"OK"` si tous les chunks ont été fusionnés et le fichier à été correctement ajouté à la galerie.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/file/uploadFile.php",
          data: {
              file: chunk,
              currentChunkNumber: 13,
              totalChunkNumber: 28,
              extension: "mp4",
              timestamp: "24.4",
              name: "Une super vidéo !",
              duration: "172",
              tags: JSON.stringify([2, 6, 7]),
          },
          success: (res) => console.log(res),
      });
      ```

- ### Dossier `back/log`

  Ce dossier comporte 2 fichiers qui permettent de ajouter et de récupérer les logs du site :
  - [`getLogs.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/log/getLogs.php)
    - Retourne un tableau contenant tous les logs du site.
    - Exemple d'utilisation :

      ```js
      $.get({
          url: "back/log/getLogs.php",
          success: (res) => console.log(JSON.parse(res)),
      });
      ```

  - [`registerLog.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/log/registerLog.php)
    - Contient une fonction qui ajoute un log dans la base de données. Ce fichier est importé dans la plupart des fichiers back pour permettre de tracker toutes les actions effectuées sur le site.
    - Exemple d'utilisation :

      ```php
      include '../log/registerLog.php';
      registerNewLog($mysqli, $_SESSION['id'], "Ceci est un super log !");
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

  - [`deleteCategory.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/deleteCategory.php)
    - Supprime une catégorie dont l'id est `IDCategorie`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/deleteCategory.php",
          data: { IDCategorie: 3 },
          success: (res) => console.log(res),
      });
      ```

  - [`deleteTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/deleteTag.php)
    - Supprime un tag dont l'id est `IDTag`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/deleteTag.php",
          data: { IDTag: 3 },
          success: (res) => console.log(res),
      });
      ```

  - [`getCategories.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/getCategories.php)
    - Retourne la liste de toutes les catégories existantes.
    - Exemple d'utilisation :

      ```js
      $.get({
          url: "back/tag/getCategories.php",
          success: (res) => console.log(JSON.parse(res)),
      });
      ```

  - [`getTags.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/getTags.php)
    - Retourne la liste de tous les tags auxquels à accès l'utilisateur qui fait la requête (par exemple, un invité n'a accès qu'à une partie des tags existants).
    - Exemple d'utilisation :

      ```js
      $.get({
          url: "back/tag/getTags.php",
          success: (res) => console.log(JSON.parse(res)),
      });
      ```

  - [`updateCategory.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/updateCategory.php)
    - Modifie le nom (`name`) et la couleur (`color`) de la catégorie dont l'id est `IDCategorie`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/updateCategory.php",
          data: { IDCategorie: 3, name: "Genre", color: "A48FCD" },
          success: (res) => console.log(res),
      });
      ```

  - [`updateTag.php`](https://github.com/Dyrudis/lbr-drive/blob/main/back/tag/updateTag.php)
    - Modifie le nom (`name`) et la catégorie (`IDCategorie`) du tag dont l'id est `IDTag`.
    - Retourne `"OK"` si l'opération s'est correctement déroulée.
    - Exemple d'utilisation :

      ```js
      $.post({
          url: "back/tag/updateTag.php",
          data: { IDTag: 7, name: "Electro", IDCategorie: 2 },
          success: (res) => console.log(res),
      });
      ```

## Front

**TODO** : Compléter cette section
