<?php

namespace App\Console\Commands\Simples;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppFirstDocUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:first_doc_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'First doc upload by user';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $documents = DB::table('users')
        ->leftJoin('documentables', function ($join) {
            $join->on('users.id', '=', 'documentables.documentable_id')
                 ->where('documentables.documentable_type', '=', 'users');
        })
        ->join('documents', 'documentables.document_id', '=', 'documents.id')
        ->where('documents.type', 'LIKE', 'image%')
        ->select('users.id as user_id', DB::raw('MIN(documents.id) as first_document_id'))
        ->groupBy('users.id')
        ->get();

        if ($documents->isEmpty()) {
            $this->info('No documents found.');
        } else {
            $this->info('Listing documents with their counts:');
            foreach ($documents as $document) {
                // Affichage de l'ID utilisateur et du nombre de documents associés
                $this->line("User ID: {$document->user_id} - First document uploaded: {$document->first_document_id}");
            }
        }
    }
}
