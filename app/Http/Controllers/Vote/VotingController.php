<?php

namespace App\Http\Controllers\Vote;

use App\Http\Controllers\Controller;
use App\Http\Requests\CloseQuestionRequest;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\VoteRequest;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    public function index()
    {
        $openVotesDidntVote = Question::open()->didntVote(Auth::user())->orderBy('closes_at');
        if (Auth::user()->is_admin) {
            $openVotesDidntVote->withCount('participatingUsers');
            $totalVotersCount = User::whereIsAdmin(false)->count();
        }

        return view('vote.index', [
            'totalVotersCount' => $totalVotersCount ?? 0,
            'openVotesDidntVote' => $openVotesDidntVote->get(),
            'openVotesVoted' => Question::open()->hasVoted(Auth::user())->orderBy('closes_at')->get(),
            'closedVotes' => Question::closed()->with('options.voteCount')->orderBy('closes_at', 'DESC')->get(),
        ]);
    }

    public function create()
    {
        return view('vote.create');
    }

    public function store(QuestionRequest $request)
    {
        $data = $request->validated();

        if ($request->has('confirm')) {
            $question = Question::create($data);
            $question->options()->createMany(array_map(fn($label) => ['label' => $label], $data['options']));
            return redirect(route('voting.index'));
        } else {
            return view('vote.confirm_create', $data);
        }
    }

    public function close(Question $question, CloseQuestionRequest $request) // $request is needed for authorization
    {
        $question->closes_at = now();
        $question->save();

        return redirect(route('voting.index'));
    }

    public function vote(Question $question)
    {
        if (Auth::user()->hasParticipated($question)) {
            return view('vote.vote_participated');
        } else if ($question->closes_at->isPast()) {
            return view('vote.vote_closed', ['vote' => $question]);
        } else {
            return view('vote.vote', ['vote' => $question]);
        }
    }

    public function storeVote(Question $question, VoteRequest $request)
    {
        $data = $request->validated();

        $question->participatingUsers()->attach($request->user(), ['option_id' => $data['option']]);

        return redirect(route('voting.index'));
    }

    public function results(Question $question)
    {
        $question->load(['options.voteCount', 'options.voters']);

        return view('vote.results', [
            'vote' => $question,
            'options_sorted' => $question->options->sortByDesc(fn($a) => $a->vote_count),
        ]);
    }
}
