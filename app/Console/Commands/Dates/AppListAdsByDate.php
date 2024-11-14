<?php

namespace App\Console\Commands\Dates;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppListAdsByDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_ads_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list users after 05/09/2019 ';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        
        $date = Carbon::parse('2019-09-05');
        $ads = DB::table('ads')
        ->select('ads.id as ad_id', 'ads.created_at as ad_created_at')
        ->where('created_at', '>=', $date)
        ->orderBy('created_at', 'DESC')
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line("ID: {$ad->ad_id} - Date: {$ad->ad_created_at} ");
            }
        }

    }
}
