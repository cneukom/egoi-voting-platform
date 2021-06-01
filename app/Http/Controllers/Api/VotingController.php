<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;

class VotingController extends Controller
{
    public function votes(Question $question)
    {
        if ($question->closes_at->isFuture()) {
            abort(403);
        }

        $options = $question->options->mapWithKeys(fn(Option $option) => [$option->id => $option->label]);
        $users = $question->participatingUsers()->withPivot('option_id')->get();

        $f = fopen('php://output', 'w');
        fputcsv($f, ['Delegation', 'Option']);
        foreach ($users as $user) {
            fputcsv($f, [
                $user->name,
                $options[$user->pivot->option_id],
            ]);
        }
    }
}
