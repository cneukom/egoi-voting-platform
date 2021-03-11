@extends('root')

@section('content')
    <h1 class="mb-4">
        {{ __('app.create.create_vote') }}
    </h1>

    <div class="alert alert-info mb-5">
        <p>{{ __('app.create.instructions.basic') }}</p>
        <p class="mb-0">{{ __('app.create.instructions.voting_deadline') }}</p>
    </div>

    <form method="post">@csrf
        <div class="form-group">
            <label for="question">{{ __('app.create.question') }}</label>
            @error('question') <p class="text-danger">{{ $message }}</p> @enderror
            <input class="form-control" id="question" name="question" value="{{ old('question') }}"/>
        </div>

        <div class="form-group">
            <label for="information">
                {{ __('app.create.information') }}
                <span class="font-weight-normal">({{ __('app.create.optional') }})</span>
            </label>
            @error('information') <span class="text-danger">{{ $message }}</span> @enderror
            <textarea class="form-control" id="information" name="information">{{ old('information') }}</textarea>
        </div>

        <div class="form-group">
            <label for="duration">
                {{ __('app.create.duration') }}
                <span class="font-weight-normal">({{ __('app.create.duration_unit') }})</span>
            </label>
            @error('duration') <p class="text-danger">{{ $message }}</p> @enderror
            <input type="number" class="form-control" id="duration" name="duration" min="0"
                   value="{{ old('duration', config('app.default_vote_duration')) }}"/>
        </div>

        <fieldset data-inject-options>
            <legend>{{ __('app.create.options') }}</legend>
            @error('options') <span class="text-danger">{{ $message }}</span> @enderror

            @foreach(old('options', ['']) as $o => $option)
                <div class="form-group">
                    @error('options.' . $o) <span class="text-danger">{{ $message }}</span> @enderror
                    <label for="option" class="sr-only">{{ __('app.create.option') }}</label>
                    <input class="form-control" id="option" name="options[]" value="{{ $option }}"/>
                </div>
            @endforeach
        </fieldset>

        <input class="btn btn-primary" type="submit" value="{{ __('app.create.next') }}"/>
    </form>
@endsection
