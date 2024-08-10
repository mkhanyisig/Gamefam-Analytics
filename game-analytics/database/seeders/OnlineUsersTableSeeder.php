<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OnlineUsersTableSeeder extends Seeder
{
    public function run()
    {
        $numberOfRecords = 1000;

        $data = [];
        for ($i = 0; $i < $numberOfRecords; $i++) {
            $data[] = [
                'count' => rand(20, 10000), // Random number inn range
                'retrieved_at' => Carbon::now()->subMinutes(rand(0, 1080)), // Random time within the last 24 hours
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert data into the table
        DB::table('online_users')->insert($data);
    }
}
