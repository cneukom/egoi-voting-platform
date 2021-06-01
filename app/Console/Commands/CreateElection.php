<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateElection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new election';

    private function nth(int $n): string
    {
        return match ($n) {
            1 => '1st',
            2 => '2nd',
            3 => '3rd',
            default => $n . 'th',
        };
    }

    private function formatQuestion(string $template, int $n): string
    {
        return str_replace(
            ['{n}', '{nth}'],
            [$n, $this->nth($n)],
            $template,
        );
    }

    public function askPositiveInt($question, $default = null): int
    {
        do {
            $openFor = $this->ask($question, $default);
        } while ($openFor != (int)$openFor || $openFor <= 0);
        return $openFor;
    }

    public function handle(): int
    {
        // get question details
        $questionTemplate = $this->ask('Question template (use {nth} as placeholder for 1st, 2nd, ...)', 'What is your {nth} choice?');
        $openFor = $this->askPositiveInt('Election duration (minutes)', config('app.default_vote_duration'));
        $numOptions = $this->askPositiveInt('Number of options');

        for ($i = 0; $i < $numOptions; $i++) {
            $options[] = $this->ask($this->nth($i + 1) . ' option');
        }

        // confirm question details
        $this->output->info('Preview: ' . $this->formatQuestion($questionTemplate, 1));
        foreach ($options as $option) {
            $this->output->info($option);
        }
        if (!$this->confirm('Continue?')) {
            return 1;
        }

        // create election
        $closesAt = now()->addSeconds(30)->roundMinute()->addMinutes($openFor);
        DB::transaction(function () use ($numOptions, $questionTemplate, $closesAt, $options, &$questions) {
            for ($i = 0; $i < $numOptions; $i++) {
                $questions[] = $question = new Question();
                $question->question = $this->formatQuestion($questionTemplate, $i + 1);
                $question->closes_at = $closesAt;
                $question->save();

                $question->options()->createMany(array_map(fn($label) => ['label' => $label], $options));
            }
        });

        $this->output->success('Election created. Question Ids: '
            . join(' ', array_map(fn(Question $question) => $question->id, $questions))
        );
        return 0;
    }
}
