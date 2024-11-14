<?php

namespace App\Console\Commands\Localisation;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppCountAnnonceCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:count_annonce_city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count annonce by city';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $cities = DB::table('cities')
        ->leftJoin('users', 'cities.id', '=', 'users.zip_code_id')
        ->leftJoin('ads', 'users.id', '=', 'ads.user_pp_id')
        ->where('ads.is_draft', '!=', '0')
        ->select('cities.id', 'cities.name as city_name', DB::raw('COUNT(ads.id) as count_annonces'))
        ->groupBy('cities.id', 'cities.name')
        ->get();

        if ($cities->isEmpty()) {
            $this->info('No cities found.');
        } else {
            $this->info('Listing cities with their counts:');
            foreach ($cities as $city) {
                // Affichage de l'ID utilisateur et du nombre de cities associés
                $this->line("Name city: {$city->city_name} - Count of annonces: {$city->count_annonces}");
            }
        }
    }
}
