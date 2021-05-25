<?php

namespace App\Providers;

use App\Services\Egoi\Contracts\CommunicationService;
use App\Services\Egoi\Keybase\CommunicationService as KeybaseCommunicationService;
use Grpc\ChannelCredentials;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Messaging\MessagingClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CommunicationService::class, KeybaseCommunicationService::class);
        $this->app->bind(MessagingClient::class, function () {
            return new MessagingClient(config('app.grpc.endpoint'), [
                'credentials' => ChannelCredentials::createInsecure(),
            ]);
        });
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
