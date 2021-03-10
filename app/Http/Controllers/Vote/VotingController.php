<?php

namespace App\Http\Controllers\Vote;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    public function index()
    {
        return view('vote.index', [
            'openVotesDidntVote' => Question::open()->didntVote(Auth::user())->orderBy('closes_at')->get(),
            'openVotesVoted' => Question::open()->hasVoted(Auth::user())->orderBy('closes_at')->get(),
            'closedVotes' => Question::closed()->with('options.voteCount')->orderBy('closes_at', 'DESC')->get(),
        ]);
    }

    public function create()
    {
        // TODO show question form
    }

    public function store()
    {
        // TODO store the question
    }

    public function vote()
    {
        // TODO show the voting form
    }

    public function storeVote(Request $request)
    {
        // TODO vote (write VotingRequest)
    }

    public function show($id)
    {
        // TODO show voting details
    }
}
