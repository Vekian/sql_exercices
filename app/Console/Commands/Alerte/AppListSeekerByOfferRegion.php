<?php

namespace App\Console\Commands\Alerte;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListSeekerByOfferRegion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_seeker_offer_region';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list seeker by offer and region';

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
        ->leftJoin('regions', 'departments.region_code', '=', 'regions.code')
        ->join('ads', 'users.id', '=', 'ads.user_pp_id')
        ->join('land_seek_ads', 'ads.id', '=', 'land_seek_ads.ad_id')
        ->leftJoin('productionable_genres', function ($join) {
            $join->on('land_seek_ads.id', '=', 'productionable_genres.productionable_genre_id')
                ->where('productionable_genres.productionable_genre_type', '=', 'land_seek_ads');
        })
        // là on récupère les annonces d'offre avec un user différent de celui des recherches
        ->leftJoin('ads as offer_ads', function ($join) {
            $join->on('users.id', '!=', 'offer_ads.user_pp_id');
        })
        ->join('land_offer_ads', 'offer_ads.id', '=', 'land_offer_ads.ad_id')
        ->join('users as offer_users', 'offer_ads.user_pp_id', '=', 'offer_users.id')
        ->leftJoin('cities as offer_cities', 'offer_users.zip_code_id', '=', 'offer_cities.id')
        ->leftJoin('departments as offer_departments', 'offer_cities.department_code', '=', 'offer_departments.code')
        ->leftJoin('regions as offer_regions', 'offer_departments.region_code', '=', 'offer_regions.code')
        ->leftJoin('productionable_genres as offer_genres', function ($join) {
            $join->on('land_offer_ads.id', '=', 'offer_genres.productionable_genre_id')
                ->where('offer_genres.productionable_genre_type', '=', 'land_offer_ads');
        })

        // on compare les annonces de recherche et d'offre
        ->whereColumn('offer_regions.code', '=', 'regions.code')
        ->whereColumn('offer_genres.production_genre_id', '=', 'productionable_genres.production_genre_id')
        ->addSelect('users.id as user_seeker_id', 'offer_users.id as user_offer_id', 'ads.id as ad_id', 'regions.name as region_name', 'productionable_genres.production_genre_id as seeker_type', 'offer_genres.production_genre_id as offer_type', 'offer_ads.id as offer_id')
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line(
                    "Id seeker ad: {$ad->ad_id} - ID offer ad: {$ad->offer_id} - Name region : {$ad->region_name}  - Seeker type : {$ad->seeker_type} - Offer type : {$ad->offer_type} - Seeker id: {$ad->user_seeker_id} - Offer id: {$ad->user_offer_id}"
                );
            }
        }
    }
}
