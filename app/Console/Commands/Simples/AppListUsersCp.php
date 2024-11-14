<?php

namespace App\Console\Commands\Simples;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AppListUsersCp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_users_cp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List users with CP starting by 6 or 0';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Query to find users with postal codes starting with 0 or 6
        $users = DB::table('users')
            ->join('cities', 'users.zip_code_id', '=', 'cities.id')
            ->where('zip_code', 'like', '0%')
            ->orWhere('zip_code', 'like', '6%')
            ->get();

        // Specify the output SQL file
        $sqlFilePath = base_path('app/users_with_cp.sql');

        // Create or open the SQL file in write mode
        $file = fopen($sqlFilePath, 'w');

        if ($users->isEmpty()) {
            $this->info('No users found with postal code starting with 0 or 6.');
        } else {
            $this->info('Listing users with postal codes starting with 0 or 6:');
            foreach ($users as $user) {
                $this->line("ID: {$user->id} - Code postal: {$user->zip_code}");

                // Write the SQL INSERT INTO command for each user
                $sql = "INSERT INTO users (id, zip_code) VALUES ({$user->id}, '{$user->zip_code}');\n";
                fwrite($file, $sql);
            }
        }

        // Close the file after writing
        fclose($file);

        $this->info("SQL file has been saved to: $sqlFilePath");
    }
}
