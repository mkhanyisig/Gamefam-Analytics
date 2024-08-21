<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use App\Models\OnlineUser;
use Illuminate\Console\Command;

class CheckActiveUsers extends Command
{
    protected $signature = 'users:check';
    protected $description = 'Fetch the number of active users and store the count in the online_users table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        // Fetch the active users count from the given base API endpoint
        $response = Http::get('https://origins.habbo.com/api/public/origins/users');

        if ($response->successful()) {
            $data = $response->json();
            $count = $data['onlineUsers'];

            // Create and store the count record in the database
            OnlineUser::create([
                'count' => $count,
                'retrieved_at' => now(),
            ]);

            \Log::info('users:check command triggered successfully. , count is ' . $count);

            $this->info('Active users count saved successfully. Count: ' . $count);
        } else {
            $this->error('Failed to fetch active users.');
        }
    }
}
