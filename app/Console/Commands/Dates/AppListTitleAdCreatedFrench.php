<?php

namespace App\Console\Commands\Dates;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppListTitleAdCreatedFrench extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_title_ads_created_french';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list ads with year creation and month in french';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        DB::statement("SET lc_time_names = 'fr_FR'");
        $ads = DB::table('ads')
        ->selectRaw('ads.title as ad_title, YEAR(ads.created_at) as year, MONTHNAME(ads.created_at) as month, DAYNAME(ads.created_at) as day')
        ->orderBy('created_at', 'DESC')
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line("Title: {$ad->ad_title} - Year: {$ad->year} - Month {$ad->month} - Day: {$ad->day}");
            }
        }

    }
}
