<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('foadino:status', fn () => $this->info('Fooladino is ready.'))->purpose('Application health status');
