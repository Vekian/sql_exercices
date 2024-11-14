<?php

namespace App\Console\Commands\Types;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListAnnonceBySeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_annonce_seek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list annonce by seek';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads = DB::table('ads')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('land_seek_ads')
                ->whereColumn('land_seek_ads.ad_id', 'ads.id');
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
