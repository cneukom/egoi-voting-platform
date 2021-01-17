<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email=admin@egoi.ch} {name=Administrator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new administrator and print its password';

    public function handle(Hasher $hasher): int
    {
        $password = Str::random(12);
        $user = new User();
        $user->email = $this->argument('email');
        $user->name = $this->argument('name');
        $user->password = $hasher->make($password);
        $user->save();
        $this->output->success('Created user ' . $this->argument('name') . ' with password ' . $password);
        return 0;
    }
}
