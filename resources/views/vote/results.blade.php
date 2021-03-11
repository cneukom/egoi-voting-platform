@extends('root')

@php
    use App\Models\Option;
    use App\Models\Question;
    use Illuminate\Database\Eloquent\Collection;
    /**
     * @var Question $vote
     * @var Option[]|Collection $options_sorted
     */
@endphp

@section('content')
    <h1 class="mb-5">
        {{ __('app.results.results') }}
        <a class="in-title float-right" href="{{ route('voting.index') }}">{{ __('app.results.back') }}</a>
    </h1>

    <h2>{{ $vote->question }}</h2>

    <p>{{ nl2br($vote->information) }}</p>

    <div class="accordion mt-5" id="accordionExample">
        @foreach($options_sorted as $option)
            <div class="card">
                <div class="card-header @if($option->vote_count === $options_sorted->first()->vote_count) text-success @endif">
                    <h3 class="mb-0">
                        {{ $option->label }} &mdash;
                        @votePercentage($option)
                    </h3>
                </div>
                <div class="card-body">
                    @if($option->voters->count() === 0)
                        <span class="text-black-50">{{ __('app.results.no_votes') }}</span>
                    @else
                        {{ $option->voters->map(fn(\App\Models\User $user) => $user->delegation)->join(', ') }}
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
