# Drive - Les briques rouges

Ce projet est un drive privé hébergé par un site internet en ligne et dédié au festival "Les briques rouges". Il a été développé par 4 étudiants en CIR3 à l'ISEN Lille.

## Installation

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

## Utilisation

### Parcourir la galerie

**TODO** : Compléter cette section

### Ajouter vos fichiers

**TODO** : Compléter cette section

### Modifier des fichiers

**TODO** : Compléter cette section

### Modifier des tags et catégories

**TODO** : Compléter cette section

### Créer, modifier et supprimer des comptes

**TODO** : Compléter cette section

### Parcourir les logs

**TODO** : Compléter cette section

### Modifier son mot de passe et son avatar

**TODO** : Compléter cette section

## Documentation

### Back

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

### Front

**TODO** : Compléter cette section
