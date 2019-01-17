<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command('queue_test1', function () {
    dispatch(new \App\Jobs\Jobtest1())->delay(now()->addSecond(10));
})->describe('Display an inspiring quote');

Artisan::command('queue_test2', function () {
    dispatch(new \App\Jobs\Jobtest2());
})->describe('Display an inspiring quote');

