@php
    /**
     * @var \App\Models\Evidence[] $evidences
     * @var \App\Models\Enums\EvidenceTypeEnum $evidenceType
     * @var string $inputId
     */
@endphp

<div class="videos" data-evidence-type="{{ $evidenceType->value }}">
    <label for="{{ $inputId }}" class="video-drop-label"></label>

    <ul class="list-group">
        @foreach($evidences as $evidence)
            <li class="list-group-item" data-id="{{ $evidence->id }}" draggable="true">
                <span data-evidence>{{ $evidence->filename }}</span>
                @if($evidence->status->equals(\App\Models\Enums\EvidenceStatusEnum::created()))
                    <span class="text-muted">({{ __('app.evidence.status.created') }})</span>
                @elseif($evidence->status->equals(\App\Models\Enums\EvidenceStatusEnum::present()))
                    <span class="text-success">({{ __('app.evidence.status.present') }})</span>
                @endif

                <a class="float-right delete-evidence" href="javascript:">×</a>
            </li>
        @endforeach
    </ul>

    <p class="drag-notice">{{ __('app.evidence.drag_or_click') }}</p>
    <input class="hidden" type="file" accept="video/*" id="{{ $inputId }}"/>
</div>
