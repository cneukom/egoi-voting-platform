@extends('root')

@php
    use App\Models\Question;
    /**
     * @var Question[] $openVotesVoted
     * @var Question[] $openVotesDidntVote
     * @var Question[] $closedVotes
     */
@endphp

@section('content')
    <h1 class="mb-5">
        {{ __('app.voting.open_votes') }}
        @if(Auth::user()->is_admin)
            <a href="{{ route('voting.create') }}"
               class="btn btn-primary float-right">+ {{ __('app.voting.create') }}</a>
        @endif
    </h1>

    @if(count($openVotesDidntVote) === 0 && count($openVotesVoted) === 0)
        @if(Auth::user()->is_admin)
            <p class="alert alert-info">{{ __('app.voting.info.no_open_votes_admin') }}</p>
        @else
            <p class="alert alert-info">{{ __('app.voting.info.no_open_votes_voter') }}</p>
        @endif
    @else
        <table class="table">
            <tr>
                <th>{{ __('app.voting.question') }}</th>
                <th>{{ __('app.voting.closes_at') }}</th>
                @if(!Auth::user()->is_admin)
                    <th>{{ __('app.voting.action') }}</th>
                @endif
            </tr>

            @foreach($openVotesDidntVote as $vote)
                <tr>
                    <td>{{ $vote->question }}</td>
                    <td>{{ $vote->closes_at->format(__('app.voting.closes_at_format')) }}</td>
                    @if(!Auth::user()->is_admin)
                        <td><a href="{{ route('voting.vote', ['question' => $vote]) }}">{{ __('app.voting.vote') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach

            @foreach($openVotesVoted as $vote)
                <tr class="text-black-50">
                    <td>{{ $vote->question }}</td>
                    <td>{{ $vote->closes_at->format(__('app.voting.closes_at_format')) }}</td>
                    @if(!Auth::user()->is_admin)
                        <td>{{ __('app.voting.voted') }}</td>
                    @endif
                </tr>
            @endforeach
        </table>
    @endif

    <h1 class="mt-5 mb-5">{{ __('app.voting.closed_votes') }}</h1>

    @if(count($closedVotes) === 0)
        <p class="alert alert-info">{{ __('app.voting.info.no_closed_votes') }}</p>
    @else
        <table class="table">
            <tr>
                <th>{{ __('app.voting.question') }}</th>
                <th>{{ __('app.voting.selected_option') }}</th>
                <th>{{ __('app.voting.votes') }}</th>
                <th>{{ __('app.voting.closed_at') }}</th>
                <th>{{ __('app.voting.action') }}</th>
            </tr>

            @foreach($closedVotes as $vote)
                <tr>
                    <td>{{ $vote->question }}</td>
                    @if($vote->selected_option)
                        <td>{{ $vote->selected_option->label }}</td>
                        <td>@votePercentage($vote->selected_option)</td>
                    @else
                        <td class="text-black-50">{{ __('app.voting.undecided') }}</td>
                        <td class="text-black-50">&mdash;</td>
                    @endif
                    <td>{{ $vote->closes_at->format(__('app.voting.closes_at_format')) }}</td>
                    <td>
                        <a href="{{ route('voting.results', ['question' => $vote]) }}">{{ __('app.voting.results') }}</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
