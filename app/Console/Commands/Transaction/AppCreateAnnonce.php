<?php

namespace App\Console\Commands\Transaction;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppCreateAnnonce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_annonce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create annonce with transaction';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $adId = DB::table('ads')->insertGetId([
                'user_admin_id' => 79,
                'user_pp_id' => 67,
                'title' => 'Titre de l\'annonce',
                'about_content' => 'Description de l\'annonce',
                'about_project_content' => 'Description du projet',
                'is_draft' => 0,
                'accept_share_contact_infos' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $seekAdId = DB::table('land_seek_ads')
            ->insertGetId([
                'ad_id' => $adId,
                'is_bio' => 0,
                'experience_farming' => "J'ai plein d'expérience",
                'surface_range_min' => 10,
                "surface_range_max" => 30,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('productionable_genres')
            ->insert([
                'production_genre_id' => 27,
                'productionable_genre_type' => 'land_seek_ads',
                'productionable_genre_id' => $seekAdId,
                'type' => 'actual',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            $documentId = DB::table('documents')
            ->insertGetId([
                'name' => 'prout.png',
                'path' => 'ads/prout.png',
                'type' => 'image/png',
                'size' => 1500000,
                'user_id' => 79,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('documentables')
            ->insert([
                'document_id' => $documentId,
                'documentable_id' => $adId,
                'documentable_type' => 'ads',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

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
