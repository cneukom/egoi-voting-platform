<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const NUM_USERS = 10;
    const NUM_QUESTIONS = 15;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // administrator
        User::factory()->create([
            'delegation' => null,
            'is_admin' => true,
            'email' => 'info@egoi.ch',
        ]);

        // delegations
        $userCounter = 0;
        $users = User::factory()->count(self::NUM_USERS)
            ->state(new Sequence(function () use (&$userCounter) {
                return [
                    'email' => 'user' . ($userCounter++) . '@egoi.ch',
                ];
            }))
            ->create();

        // questions with answer options
        /** @var Question[] $questions */
        $questions = Question::factory()
            ->count(self::NUM_QUESTIONS)
            ->has(Option::factory()->count(rand(2, 5)))
            ->create();

        // random votes
        // each User participates in each Question with probability 0.5
        // a User that participates, chooses an answer u.a.r.
        foreach ($questions as $question) {
            foreach ($users as $user) {
                if (rand(0, 1) == 0) {
                    $question->participatingUsers()->attach($user, [
                        'option_id' => $question->options->random(1)[0]->id,
                    ]);
                }
            }

        }
    }
}
