@extends('root')

@section('content')
    <h1 class="mb-4">
        {{ __('app.create.create_vote') }}
    </h1>

    <div class="alert alert-warning mb-5">
        {{ __('app.create.confirm') }}
    </div>

    <form method="post">@csrf
        <input type="hidden" name="confirm"/>
        <input type="hidden" name="question" value="{{ $question }}"/>
        <textarea class="d-none" aria-hidden="true" name="information">{{ $information }}</textarea>
        <input type="hidden" name="duration" value="{{ $duration }}"/>
        @foreach($options as $option)
            <input type="hidden" name="options[]" value="{{ $option }}"/>
        @endforeach

        <div class="form-group">
            <label>{{ __('app.create.question') }}</label>
            <p>{{ $question }}</p>
        </div>

        <div class="form-group">
            <label>{{ __('app.create.information') }}</label>
            <p class="text-pre-wrap">{{ $information }}</p>
        </div>

        <div class="form-group">
            <label>{{ __('app.create.duration') }}</label>
            <p>{{ $duration }} {{ __('app.create.duration_unit') }}
                {{ __('app.create.closes_at_approx', ['time' => $closes_at->timezone(config('app.display_timezone'))->format('H:i')]) }}</p>
        </div>

        <fieldset>
            <legend>{{ __('app.create.options') }}</legend>

            <ul>
                @foreach($options as $option)
                    <li>{{ $option }}</li>
                @endforeach
            </ul>
        </fieldset>

        <input class="btn btn-primary" type="submit" value="{{ __('app.create.create') }}"/>
        <a class="btn btn-secondary" type="button" href="javascript:history.back()">{{ __('app.create.back') }}</a>
    </form>
@endsection
