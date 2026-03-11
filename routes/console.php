<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:deezer:sync 132 "Pop"')
    ->everyFiveMinutes()
    ->withoutOverlapping();
    
Schedule::command('app:deezer:sync 152 "Rock"')
    ->everyTenMinutes()
    ->withoutOverlapping();
    
Schedule::command('app:deezer:sync 110 "Jazz"')
    ->everyMinute()
    ->withoutOverlapping();
    
Schedule::command('app:deezer:sync 464 "Metal"')
    ->everyTwentySeconds()
    ->withoutOverlapping();
    
Schedule::command('app:deezer:sync 119 "Thai Country"')
    ->weekdays()
    ->at('13:00')
    ->timezone('Asia/Bangkok');