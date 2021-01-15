@php
    /** @var \App\Models\Delegation $delegation */
@endphp

@extends('root')

@section('content')
    <h1 class="mb-5">{{ __('app.evidence.overview') }}</h1>

    @foreach($delegation->contestants as $contestant)
        <div data-contestant-id="{{ $contestant->id }}">
            <h2 class="mb-3" data-contestant>{{ $contestant->name }}</h2>
            <div class="row mb-5">
                <div class="col-6">
                    <h3>{{ __('app.evidence.screenCaptures') }}</h3>
                    <x-evidence-widget :evidences="$contestant->screenCaptures"/>
                </div>
                <div class="col-6">
                    <h3>{{ __('app.evidence.workScenes') }}</h3>
                    <x-evidence-widget :evidences="$contestant->workScenes"/>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="deleteEvidenceModal" tabindex="-1" aria-labelledby="deleteEvidenceLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEvidenceLabel">{{ __('app.modal.delete.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('app.modal.delete.message') }}</p>
                    <table>
                        <tr>
                            <th class="pr-3">{{ __('app.contestant.label') }}</th>
                            <td data-contestant></td>
                        </tr>
                        <tr>
                            <th class="pr-3">{{ __('app.evidence.label') }}</th>
                            <td data-evidence></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('app.modal.actions.cancel') }}</button>
                    <button type="button" class="btn btn-danger"
                            data-action>{{ __('app.modal.actions.delete') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
