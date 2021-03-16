<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Egoi\Contracts\CommunicationService;
use App\Services\Egoi\Import\DelegationReader;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportDelegations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import delegations into database.';

    private CommunicationService $comm;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CommunicationService $comm)
    {
        parent::__construct();
        $this->comm = $comm;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle(): int
    {
        $importer = new DelegationReader($this->argument('file'));
        foreach ($importer->records() as $delegation) {
            $user = new User();
            $user->name = $delegation->name;
            $user->is_admin = false;
            $user->delegation = $delegation->name;
            $user->auth_token = Str::random(config('auth.token_length'));
            $user->save();

            $this->comm->sendMessage(config('app.notifications.channel_type'), $user->delegation,
                __('notifications.user_import.welcome', [
                    'url' => route('login_by_token', ['token' => $user->auth_token]),
                ]),
            );
        }
        return 0;
    }
}
