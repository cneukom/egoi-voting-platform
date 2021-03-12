@extends('root')

@section('content')
    <h1 class="mb-5">
        {{ __('app.vote_participated.vote_participated') }}
        <a class="in-title float-right" href="{{ route('voting.index') }}">{{ __('app.vote.back') }}</a>
    </h1>

    <div class="alert alert-danger">{{ __('app.vote_participated.message') }}</div>
@endsection
