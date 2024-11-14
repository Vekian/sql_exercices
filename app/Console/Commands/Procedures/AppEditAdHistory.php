<?php

namespace App\Console\Commands\Procedures;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppEditAdHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:edit_ad_history {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'edit ad with trigger';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        /*
            USE advanced_tp;

            DELIMITER //

            CREATE TRIGGER before_ad_update
            BEFORE UPDATE ON ads
            FOR EACH ROW
            BEGIN
                INSERT INTO ads_history(ad_id, updated_at)
                VALUES (NEW.id, NOW());
            END;//

            DELIMITER ;
        */
        $adId = $this->argument('id') ?? 1;
        
        DB::table('ads')
        ->where('id', '=', $adId)
        ->update([
            'title' => 'nouvelle modification'
        ]);
    }
}
