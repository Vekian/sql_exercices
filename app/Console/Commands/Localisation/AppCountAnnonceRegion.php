<?php

namespace App\Console\Commands\Localisation;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppCountAnnonceRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:count_annonce_region';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count annonce by region';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $regions = DB::table('regions')
        ->leftJoin('departments', 'regions.code', '=', 'departments.region_code')
        ->leftJoin('cities', 'departments.code', '=', 'cities.department_code')
        ->leftJoin('users', 'cities.id', '=', 'users.zip_code_id')
        ->leftJoin('ads', 'users.id', '=', 'ads.user_pp_id')
        ->where('ads.is_draft', '!=', '0')
        ->select('regions.id', 'regions.name as region_name', DB::raw('COUNT(ads.id) as count_annonces'))
        ->groupBy('regions.id', 'regions.name')
        ->get();

        if ($regions->isEmpty()) {
            $this->info('No regions found.');
        } else {
            $this->info('Listing regions with their counts:');
            foreach ($regions as $region) {
                $this->line("Name region: {$region->region_name} - Count of annonces: {$region->count_annonces}");
            }
        }
    }
}
