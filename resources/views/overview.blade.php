@php
    /** @var \App\Models\Delegation[] $delegations */
@endphp

@extends('root')

@section('content')
    <h1 class="mb-5">{{ __('app.evidence.overview') }}</h1>

    @foreach($delegations as $delegation)
        <table class="table mt-5 mb-5 evidence-table">
            <thead>
            <tr>
                <th scope="col">{{ $delegation->name }}</th>
                <th scope="col">{{ __('app.evidence.screenCaptures') }}</th>
                <th scope="col">{{ __('app.evidence.workScenes') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($delegation->contestants as $contestant)
                <tr>
                    <th scope="row">{{ $contestant->name }}</th>
                    <x-evidence-summary :evidences="$contestant->screenCaptures"/>
                    <x-evidence-summary :evidences="$contestant->workScenes"/>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
