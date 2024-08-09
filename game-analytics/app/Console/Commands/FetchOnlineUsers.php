<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\OnlineUser;

class FetchOnlineUsers extends Command
{
    protected $signature = 'fetch:online-users';
    protected $description = 'Fetch the number of online users from the API and store it in the database';

    public function handle()
    {
        $response = Http::get('https://origins.habbo.com/api/public/origins/users');
        $userCount = $response->json()['onlineUsers'] ?? null;

        if ($userCount) {
            OnlineUser::create([
                'count' => $userCount,
                'retrieved_at' => now(),
            ]);
            $this->info('Online users count fetched and stored successfully.');
        } else {
            $this->error('Failed to fetch data from the API.');
        }
    }
}

