<?php

namespace Database\Seeders;

use App\Models\Contestant;
use App\Models\Delegation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private function makeContestant(Delegation $delegation, int $idx): Contestant
    {
        $contestant = new Contestant();
        $contestant->name = 'Sample ' . $delegation->name . (1 + $idx);
        $contestant->code = $delegation->code . $idx;
        $contestant->access_token = Str::random(64);
        $contestant->delegation()->associate($delegation);
        $contestant->save();
        return $contestant;
    }

    private function makeDelegation(string $name, string $code): Delegation
    {
        $delegation = new Delegation();
        $delegation->code = $code;
        $delegation->name = $name;
        $delegation->access_token = Str::random(64);
        $delegation->save();

        for ($i = 0; $i < 4; $i++) {
            $this->makeContestant($delegation, $i);
        }
        return $delegation;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->makeDelegation('Switzerland', 'CH');
        $this->makeDelegation('Italy', 'IT');
    }
}
