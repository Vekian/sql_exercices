<?php

namespace App\Console\Commands\Procedures;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppCreateAdByProc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_ad_proc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create ad with procedure';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        /*
            DELIMITER //

            CREATE PROCEDURE InsertAdWithDependencies(
                IN user_admin_id INT,
                IN user_pp_id INT,
                IN ad_title VARCHAR(255),
                IN about_content TEXT,
                IN about_project_content TEXT,
                IN is_draft BOOLEAN,
                IN accept_share_contact_infos BOOLEAN,
                IN is_bio BOOLEAN,
                IN experience_farming TEXT,
                IN surface_range_min INT,
                IN surface_range_max INT,
                IN production_types JSON,
                IN document_name VARCHAR(255),
                IN document_path VARCHAR(255),
                IN document_type VARCHAR(255),
                IN document_size INT,
                IN document_user_id INT
            )
            BEGIN
                DECLARE ad_id INT;
                DECLARE seek_ad_id INT;
                DECLARE document_id INT;

                -- Début de la transaction
                START TRANSACTION;

                -- Insertion dans la table `ads`
                INSERT INTO ads (user_admin_id, user_pp_id, title, about_content, about_project_content, is_draft, accept_share_contact_infos, created_at, updated_at)
                VALUES (user_admin_id, user_pp_id, ad_title, about_content, about_project_content, is_draft, accept_share_contact_infos, NOW(), NOW());
                SET ad_id = LAST_INSERT_ID();

                -- Insertion dans la table `land_seek_ads`
                INSERT INTO land_seek_ads (ad_id, is_bio, experience_farming, surface_range_min, surface_range_max, created_at, updated_at)
                VALUES (ad_id, is_bio, experience_farming, surface_range_min, surface_range_max, NOW(), NOW());
                SET seek_ad_id = LAST_INSERT_ID();

                -- Insertion dans la table `productionable_genres`
                SET @index = 0;
                WHILE JSON_EXTRACT(production_types, CONCAT('$[', @index, ']')) IS NOT NULL DO
                    SET @type = JSON_UNQUOTE(JSON_EXTRACT(production_types, CONCAT('$[', @index, ']')));

                    -- Insertion de chaque type dans la table
                    INSERT INTO productionable_genres (production_genre_id, productionable_genre_type, productionable_genre_id, type, created_at, updated_at)
                    VALUES (@type, 'land_seek_ads', seek_ad_id, 'actual', NOW(), NOW());

                    SET @index = @index + 1;
                END WHILE;

                -- Insertion dans la table `documents`
                INSERT INTO documents (name, path, type, size, user_id, created_at, updated_at)
                VALUES (document_name, document_path, document_type, document_size, document_user_id, NOW(), NOW());
                SET document_id = LAST_INSERT_ID();

                -- Insertion dans la table `documentables`
                INSERT INTO documentables (document_id, documentable_id, documentable_type, created_at, updated_at)
                VALUES (document_id, ad_id, 'ads', NOW(), NOW());

                -- Validation de la transaction
                COMMIT;
            END //

            DELIMITER ;
        */
        try {
            DB::statement('CALL InsertAdWithDependencies(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                79,                      // user_admin_id
                67,                      // user_pp_id
                'Titre de l\'annonce',    // ad_title
                'Description de l\'annonce', // about_content
                'Description du projet',  // about_project_content
                0,                        // is_draft
                1,                        // accept_share_contact_infos
                0,                        // is_bio
                'J\'ai plein d\'expérience', // experience_farming
                10,                       // surface_range_min
                30,                       // surface_range_max
                json_encode([27, 19, 21]),                       // production_type
                'prout.png',              // document_name
                'ads/prout.png',          // document_path
                'image/png',              // document_type
                1500000,                  // document_size
                79                        // document_user_id
            ]);
        } catch (\Exception $e) {
            // Gestion de l'exception
            throw $e;
        }
    }
}
