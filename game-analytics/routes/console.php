<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('users:check')->everyMinute();  // for testing purposes, switch back to 10 mins

Schedule::call(function () { // test cron job to write to a log file
    file_put_contents(storage_path('logs/test.log'), 'Cron job executed: ' . now() . PHP_EOL, FILE_APPEND);
})->hourly();