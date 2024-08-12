<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OnlineUsersTableSeeder extends Seeder
{
    public function run()
    {

        // Truncate the table to remove all existing data
        DB::table('online_users')->truncate();

        $numberOfRecords = 1008;
        $maxUsers = 4000;
        $minUsers = 200;
        $cycleLength = $numberOfRecords / 2; 

        $data = [];
        for ($i = 0; $i < $numberOfRecords; $i++) {
            // Simulate a gradual increase and then decrease in user count
            $scale = ($maxUsers - $minUsers) / 2;
            $offset = ($maxUsers + $minUsers) / 2;
            $userCount = $scale * sin(M_PI * $i / $cycleLength) + $offset;

            $data[] = [
                'count' => round($userCount),
                'retrieved_at' => Carbon::now()->subMinutes(10*$i), // Random time in the past
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('online_users')->insert($data);
    }
}
