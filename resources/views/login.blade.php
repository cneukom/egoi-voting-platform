@extends('root')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ __('auth.login.login') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('auth.login.email') }}</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                           autofocus/>
                </div>

                <div class="form-group">
                    <label for="password">{{ __('auth.login.password') }}</label>
                    <input id="password" class="form-control" type="password" name="password" required
                           autocomplete="current-password"/>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('auth.login.login') }}</button>
            </form>
        </div>
    </div>
@endsection
