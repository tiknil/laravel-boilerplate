<?php

use Illuminate\Support\Facades\Schedule;

/*
if (config('app.env') === 'production' && !config('app.staging')) {
    Schedule::command('backup')->dailyAt('02:00')->withoutOverlapping();
}
*/

Schedule::command('audit:clear-old-logs')->monthlyOn(1, '01:00');
