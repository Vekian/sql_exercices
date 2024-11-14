<?php

namespace App\Console\Commands\Alerte;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListSeekerByOfferDept extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_seeker_offer_dept';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list seeker by offer and dept';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // on récupère les annonces de recherche
        $ads = DB::table('users')
        ->leftJoin('cities', 'users.zip_code_id', '=', 'cities.id')
        ->leftJoin('departments', 'cities.department_code', '=', 'departments.code')
        ->join('ads', 'users.id', '=', 'ads.user_pp_id')
        ->join('land_seek_ads', 'ads.id', '=', 'land_seek_ads.ad_id')

        // là on récupère les annonces d'offre
        ->leftJoin('ads as offer_ads', function ($join) {
            $join->on('users.id', '!=', 'offer_ads.user_pp_id');
        })
        ->join('land_offer_ads', 'offer_ads.id', '=', 'land_offer_ads.ad_id')
        ->join('users as offer_users', 'offer_ads.user_pp_id', '=', 'offer_users.id')
        ->leftJoin('cities as offer_cities', 'offer_users.zip_code_id', '=', 'offer_cities.id')
        ->leftJoin('departments as offer_departments', 'offer_cities.department_code', '=', 'offer_departments.code')


        // on compare les annonces de recherche et d'offre
        ->whereColumn('offer_departments.code', '=', 'departments.code')
        ->whereBetween('land_offer_ads.surface', [
            DB::raw('land_seek_ads.surface_range_min'),
            DB::raw('land_seek_ads.surface_range_max')
        ])
        ->addSelect('users.id as user_seeker_id', 'land_offer_ads.surface as offer_surface', 'land_seek_ads.surface_range_min as seek_surface_min', 'land_seek_ads.surface_range_max as seek_surface_max', 'offer_users.id as user_offer_id', 'ads.id as ad_id', 'departments.name as department_name', 'offer_ads.id as offer_id')
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line(
                    "Id seeker ad: {$ad->ad_id} - ID offer ad: {$ad->offer_id} - Name department : {$ad->department_name} - Seeker id: {$ad->user_seeker_id} - Offer id: {$ad->user_offer_id} - Surface: offer:{$ad->offer_surface}  seeker: min{$ad->seek_surface_min} max{$ad->seek_surface_max}"
                );
            }
        }
    }
}
