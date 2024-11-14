<?php

namespace App\Console\Commands\Simples;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListProdName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_prod_name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List type production with name child';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Requête pour obtenir tous les types de productions avec les enfants concaténés
        $productions = DB::table('production_genres as pg1')
        ->leftJoin('production_genres as pg2', 'pg1.id', '=', 'pg2.parent_id')
        ->select('pg1.id as parent_id', 'pg1.name as parent_name', DB::raw('GROUP_CONCAT(pg2.name SEPARATOR ", ") as children_names'))
        ->groupBy('pg1.id', 'pg1.name')
        ->get();

        if ($productions->isEmpty()) {
            $this->info('No productions found.');
        } else {
            $this->info('Listing productions with their children:');
            foreach ($productions as $production) {
                // Affichage des résultats avec les noms des enfants concaténés
                $this->line("Parent Production ID: {$production->parent_id} - Parent Name: {$production->parent_name} - Children: {$production->children_names}");
            }
        }
    }
}
