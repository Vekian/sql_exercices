<?php

namespace App\Console\Commands\Simples;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListProdAnnonce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_prod_annonce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List type production without annonce';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Query to find users with postal codes starting with 0 or 6
        $productions = DB::table('production_genres')
        ->leftJoin('productionable_genres', 'production_genres.id', '=', 'productionable_genres.production_genre_id')
        ->whereNull('productionable_genres.id')
        
/*         ->leftJoin('land_offer_ads', function ($join) {
            $join->on('productionable_genres.productionable_genre_id', '=', 'land_offer_ads.id')
                 ->where('productionable_genres.productionable_genre_type', '=', 'land_offer_ads');
        })
        ->leftJoin('land_seek_ads', function ($join) {
            $join->on('productionable_genres.productionable_genre_id', '=', 'land_seek_ads.id')
                 ->where('productionable_genres.productionable_genre_type', '=', 'land_seek_ads');
        }) */
        ->get();

        if ($productions->isEmpty()) {
            $this->info('No productions found with postal code starting with 0 or 6.');
        } else {
            $this->info('Listing productions with postal codes starting with 0 or 6:');
            foreach ($productions as $production) {
                $this->line("ID: {$production->id} - Surface: {$production->type}");
            }
        }
    }
}
