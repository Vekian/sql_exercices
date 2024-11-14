<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppDeleteAnnonce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete_annonce {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete annonce with transaction';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        DB::beginTransaction();
        $adId = $this->argument('id') ?? 1;

        try {
            $seekAd = DB::table('land_seek_ads')
                    ->where('ad_id', '=', $adId)
                    ->first();
            DB::table('land_seek_ads')
            ->where('ad_id', '=', $adId)
            ->delete();

            /* DB::table('ads_history')
            ->where('ad_id', '=', $adId)
            ->delete(); */


            DB::table('ads')
            ->where('id', '=', $adId)
            ->delete();

            DB::table('productionable_genres')
            ->where('productionable_genre_id', '=', $seekAd->id)
            ->where('productionable_genre_type', '=', 'land_seek_ads')
            ->delete();

            $documentId = DB::table('documentables')
            ->select('document_id')
            ->where('documentable_type', '=', 'land_seek_ads')
            ->where('documentable_id', '=', $adId);

            DB::table('documentables')
            ->where('documentable_id', '=', $adId)
            ->where('documentable_type', '=', 'land_seek_ads')
            ->delete();

            DB::table('documents')
            ->where('id', '=', $documentId)
            ->delete();


            DB::commit();
        } catch (\Exception $e) {
            // En cas d'erreur, annuler toutes les opérations effectuées dans la transaction
            DB::rollBack();
        
            // Vous pouvez éventuellement loguer l'erreur ou la relancer
            // Log::error($e->getMessage());
            throw $e; // Relancer l'exception si nécessaire
        }


    }
}
