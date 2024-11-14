<?php

namespace App\Console\Commands\Dates;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppListUsersMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_users_month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'list users last 48 months ';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        
        
        $users = DB::table('users')
        ->select('users.id as user_id', 'users.updated_at as user_updated_at')
        ->where('updated_at', '>=', Carbon::now()->subMonths(48))
        ->orderBy('updated_at', 'DESC')
        ->get();


        if ($users->isEmpty()) {
            $this->info('No users found.');
        } else {
            $this->info('Listing users with their type:');
            foreach ($users as $user) {
                $this->line("ID: {$user->user_id} - Date: {$user->user_updated_at} ");
            }
        }

    }
}
