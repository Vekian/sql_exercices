<?php

namespace App\Console\Commands\Types;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListAnnonceByOffer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_annonce_offer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list annonce by offer';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('land_offer_ads')
                ->whereColumn('land_offer_ads.ad_id', 'ads.id');
        })
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line("ID: {$ad->id} - Name ad: {$ad->title} ");
            }
        }
    }
}
