<?php

namespace App\Console\Commands\Distance;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListCitiesByLatAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_city_lat_all {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list near cities by latitude';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $cityId = $this->argument('id') ?? 1;
        // on récupère les annonces de recherche
        $cities = DB::table('cities')
        ->selectRaw('6366 * acos(cos(radians((SELECT gps_lat FROM cities WHERE id = ?))) 
                    * cos(radians(cities.gps_lat)) 
                    * cos(radians(cities.gps_lng) - radians((SELECT gps_lng FROM cities WHERE id = ?))) 
                    + sin(radians((SELECT gps_lat FROM cities WHERE id = ?))) 
                    * sin(radians(cities.gps_lat))) AS distance', [
                        $cityId,
                        $cityId,
                        $cityId
                    ])
        ->addSelect('cities.id as city_id')
        ->orderBy('distance')  // Trie par distance croissante
        ->get();

        if ($cities->isEmpty()) {
            $this->info('No cities found.');
        } else {
            $this->info('Listing cities with their type:');
            $count = count($cities);
            foreach ($cities as $city) {
                $this->line(
                    "id: {$city->city_id} distance: {$city->distance} count: {$count}"
                );
            }
        }
    }
}
