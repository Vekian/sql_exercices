<?php

namespace App\Console\Commands\Localisation;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppCountAnnonceDept extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:count_annonce_dept';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count annonce by dept';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $departments = DB::table('departments')
        ->leftJoin('cities', 'departments.code', '=', 'cities.department_code')
        ->leftJoin('users', 'cities.id', '=', 'users.zip_code_id')
        ->leftJoin('ads', 'users.id', '=', 'ads.user_pp_id')
        ->where('ads.is_draft', '!=', '0')
        ->select('departments.id', 'departments.name as department_name', DB::raw('COUNT(ads.id) as count_annonces'))
        ->groupBy('departments.id', 'departments.name')
        ->get();

        if ($departments->isEmpty()) {
            $this->info('No departments found.');
        } else {
            $this->info('Listing departments with their counts:');
            foreach ($departments as $department) {
                $this->line("Name department: {$department->department_name} - Count of annonces: {$department->count_annonces}");
            }
        }
    }
}
