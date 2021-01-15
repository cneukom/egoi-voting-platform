@php
    /** @var \App\Models\Evidence[] $evidences */
@endphp

<div class="videos">
    <ul class="list-group">
        @foreach($evidences as $evidence)
            <li class="list-group-item list-group-item-action" data-id="{{ $evidence->id }}">
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
</div>
