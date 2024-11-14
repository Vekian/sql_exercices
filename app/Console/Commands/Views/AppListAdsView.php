<?php

namespace App\Console\Commands\Views;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppListAdsView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_ads_view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list ads and seek ads with view ';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $ads =  DB::table('list_seek_ads')->get();
        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line("ID: {$ad->ad_id} - title: {$ad->title} - experience: {$ad->experience_farming}");
            }
        }

    }
}
