<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        date_default_timezone_set(config('app.timezone', 'Asia/Tehran'));
        try {
            View::share('siteSettings', Setting::pluck('value', 'key')->all());
        } catch (\Throwable $e) {
            View::share('siteSettings', []);
        }
    }
}
