<?php

namespace App\Console\Commands\Dates;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppListTitleAdByDayCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_title_ads_day_created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list ads with days creation';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $date = Carbon::now();
        $ads = DB::table('ads')
        ->selectRaw('ads.title as ad_title, DATEDIFF(?, ads.created_at) as day_date', [$date])
        ->get();


        if ($ads->isEmpty()) {
            $this->info('No ads found.');
        } else {
            $this->info('Listing ads with their type:');
            foreach ($ads as $ad) {
                $this->line("Title: {$ad->ad_title} - Day from creation: {$ad->day_date}");
            }
        }

    }
}
