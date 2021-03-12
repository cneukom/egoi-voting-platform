@extends('root')

@php
    use App\Models\Question;
    /** @var Question $vote */
@endphp

@section('content')
    <h1 class="mb-5">
        {{ __('app.vote_closed.vote_closed') }}
        <a class="in-title float-right" href="{{ route('voting.index') }}">{{ __('app.vote.back') }}</a>
    </h1>

    <div class="alert alert-danger">{{ __('app.vote_closed.message', ['time' => $vote->closes_at->format(__('app.voting.closes_at_format'))]) }}</div>
@endsection
