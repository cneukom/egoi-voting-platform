@extends('root')

@php
    use App\Models\Question;
    /** @var Question $vote */
@endphp

@section('content')
    <h1 class="mb-5">
        {{ __('app.vote.vote') }}
        <a class="in-title float-right" href="{{ route('voting.index') }}">{{ __('app.vote.back') }}</a>
    </h1>

    <div
        class="alert alert-info mb-5">{{ __('app.vote.instructions', ['time' => $vote->closes_at->format(__('app.voting.closes_at_format'))]) }}</div>

    <h2>{{ $vote->question }}</h2>

    @if($vote->information)
        <p class="text-pre-wrap">{{ $vote->information }}</p>
    @endif

    <form method="post">@csrf
        <div class="mt-4 mb-4">
            @error('option') <p class="text-danger">{{ $message }}</p> @enderror
            @foreach($vote->options as $option)
                <div class="vote-option">
                    <input type="radio" name="option" id="option{{ $option->id }}" value="{{ $option->id }}"/>
                    <label for="option{{ $option->id }}">
                        {{ $option->label }}
                        <span class="selected">✔</span>
                    </label>
                </div>
            @endforeach
        </div>

        <input class="btn btn-primary" type="submit" value="{{ __('app.vote.submit') }}"/>
    </form>
@endsection
