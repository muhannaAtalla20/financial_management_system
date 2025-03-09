<?php

use App\Jobs\CreateSalary;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('telescope:prune')->daily();
// Schedule::command('backup:clean');
// Schedule::command('backup:run');
