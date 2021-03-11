<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('votePercentage', function ($option) {
            return "<?= number_format(($option)->vote_count / ($option)->question->total_votes * 100, 2); ?>&nbsp;%";
        });
    }
}
