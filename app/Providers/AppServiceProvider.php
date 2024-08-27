<?php

namespace App\Providers;

use App\Extensions\FileStore;
use Facades\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (strpos(url()->to(""), "localhost") === false && strpos(url()->to(""), "127.0.0.1") === false && strpos(url()->to(""), "0.0.0.0") === false) {
            \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // additional
        Cache::extend('file', function ($app) {
            return Cache::repository(new FileStore($app['files'], config('cache.stores.file.path'), null));
        });

        $onlineUsers = [];
        foreach (FileStore::getKeys() as $value) {
            if (str_contains($value, 'online-users-')) {
                $onlineUsers[] = Cache::get($value);
            }
        }

        // $appPrefix = Str::slug(env('APP_NAME', 'laravel'), '_');
        // $cachePrefix = $appPrefix . '_cache_';
        // $databasePrefix = $appPrefix . '_database_';
        // $onlineUsers = [];
        // foreach (Redis::keys($cachePrefix . ':online-users-*') as $key) {
        //     $cacheKeyWithoutPrefix = str_replace($databasePrefix . $cachePrefix . ':', '', $key);
        //     $onlineUsers[] = Cache::get($cacheKeyWithoutPrefix);
        // }

        View::share('onlineUsers', $onlineUsers);
    }
}
