<?php

namespace App\Providers;

use App\Services\Egoi\Contracts\CommunicationService;
use App\Services\Egoi\Mocks\CommunicationService as CommunicationServiceMock;
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
        $this->app->bind(CommunicationService::class, CommunicationServiceMock::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('votePercentage', function ($option) {
            return "<?= ($option)->question->total_votes === 0 ? 'N/A' : number_format(($option)->vote_count / ($option)->question->total_votes * 100, 2) . '&nbsp;%'; ?>";
        });
    }
}
