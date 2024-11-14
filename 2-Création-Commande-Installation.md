# SQL Avancé - TP

## Création de la commande d'installation

Vous trouverez dans le dossier [files](./files/) une archive zip, qu'il vous faudra télécharger.

À l'intérieur se trouve un fichier sql_avance_tp_mwb. Ouvrez ce diagramme avec MySQL Workbench pour observer le diagramme de la BDD de ce TP.

A partir du diagramme, un fichier SQL a été extrait pour que toute la création des tables soit automatisée.
Vous êtes censé savoir faire tout le SQL à la main, mais dans la réalité on ne le fait jamais comme ça ! On passe d'abord par le diagramme, puis on utilise des outils pour transformer ça ensuite dans un script de migration.

Pour générer le fichier SQL, il faut habituellement ouvrir le modèle puis allez simplement dans File / Export / Forward Engineer. **Attention : ce n'est pas nécessaire de le faire pour ce TP.**

Pour faciliter le TP et aller tout de suite à l'essentiel, j'ai généré pour vous toutes les migrations. Faites une extraction à la racine de votre projet de l'archive **sql_.zip**, de sortes à obtenir un dossier nommé "sql" à la racine de votre projet.

Dans le dossier [files](./files/), récupérer la commande Lumen **AppInstall.php** (qui est en fait une commande symfony) et copiez-là dans votre dossier :
```
app/Console/Commands
```

Enfin ajoutez ces morceaux de code dans votre fichier *app/console/Kernel.php* : 

```php

use App\Console\Commands\AppInstall;

//...

    protected $commands = [
        AppInstall::class
    ];

```

Une fois ces 2 étapes terminées vous allez exécuter la commande suivante : 

```
php artisan app:install
```

Ouvrez votre éditeur de base de données (PhpMyAdmin ou HeidiSQL ou MySQL WorkBench ...) et constatez la bonne création de toutes les tables et des données.

[To Be Continued... Identifer les relations](./3-Identifier-Relations.md)