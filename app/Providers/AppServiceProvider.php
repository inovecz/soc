<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Http\Request::macro('pageIs', function ($pattern) {
            return $this->is('livewire/message/*')
                ? Str::is(url($pattern), Str::before($this->header('referer'), '?'))
                : $this->is($pattern);
        });
    }
}
