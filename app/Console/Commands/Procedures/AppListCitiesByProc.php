<?php

namespace App\Console\Commands\Procedures;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListCitiesByProc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_city_proc {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list near cities by latitude with procedure';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        /*
            USE advanced_tp;

            DELIMITER //

            CREATE PROCEDURE FindCitiesByLat(IN city_id INT, IN max_distance FLOAT)
            BEGIN
                SELECT
                    (6366 * acos(
                        cos(radians((SELECT gps_lat FROM cities WHERE id = city_id)))
                        * cos(radians(c.gps_lat))
                        * cos(radians(c.gps_lng) - radians((SELECT gps_lng FROM cities WHERE id = city_id)))
                        + sin(radians((SELECT gps_lat FROM cities WHERE id = city_id)))
                        * sin(radians(c.gps_lat))
                    )) AS distance,
                    c.id AS id
                FROM
                    cities AS c
                HAVING
                    distance < max_distance
                ORDER BY
                    distance;
            END //

            DELIMITER ;
        */
        $cityId = $this->argument('id') ?? 1;
        // on récupère les annonces de recherche
        $cities =DB::select('CALL FindCitiesByLat(?, ?)', [$cityId, 20]);

        if (!$cities) {
            $this->info('No cities found.');
        } else {
            $this->info('Listing cities with their type:');
            $count = count($cities);
            foreach ($cities as $city) {
                $this->line(
                    "id: {$city->id} distance: {$city->distance} count: {$count}"
                );
            }
        }
    }
}
