<?php

namespace App\Console\Commands\Simples;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListUsersDept extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_users_dept';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List users with Department';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Query to find users with postal codes starting with 0 or 6
        $users = DB::table('users')
                    ->join('cities', 'users.zip_code_id', '=', 'cities.id')
                    ->join('departments', 'cities.department_code', '=', 'departments.code')
                    ->get();

        if ($users->isEmpty()) {
            $this->info('No users found with postal code starting with 0 or 6.');
        } else {
            $this->info('Listing users with postal codes starting with 0 or 6:');
            foreach ($users as $user) {
                $this->line("ID: {$user->id} - Departement: {$user->code}");
            }
        }
    }
}
