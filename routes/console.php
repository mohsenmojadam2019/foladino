<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('foadino:status', fn () => $this->info('Fooladino is ready.'))->purpose('Application health status');
use Illuminate\Support\Facades\Schedule;

Schedule::command('queue:prune-batches --hours=48')->daily();
