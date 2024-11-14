# SQL Avancé - TP

## Query Builder

Les requêtes suivantes sont à créer avec le Query Builder de Lumen.
Il faut créer ces requêtes à l'intérieur d'une commande Lumen.

Exemple d'une commande qui exécute une requête avec QueryBuilder et affiche les résultats : 

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Exo17 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exo17';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exercices autour du query builder';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $exoA = app('db')
            ->table("users")
            ->select('*')
          	->limit(1)
            ->get();

        var_dump($exoA);
    }
}

```

N'oubliez pas d'ajouter votre nouvelle commande dans votre *App/Console/Kernel* : 
```php
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AppInstall::class,
        Exo17::class
    ];

    //...
}
```

### A - Trouver tous les utilisateurs qui se sont connectés les 48 derniers mois, triés de la plus récente connexion à la plus ancienne (updated_at est la colonne qui contient la dernière date de connexion)

### B - Lister tous les utilisateurs dont le code postal commence par 6 ou 0