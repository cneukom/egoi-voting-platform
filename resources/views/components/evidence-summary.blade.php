@php /** @var \App\Models\Evidence[] $evidences */ @endphp

<td>
    @foreach($evidences as $evidence)
        @if(\App\Models\Enums\EvidenceStatusEnum::present()->equals($evidence->status))
            <span class="badge badge-success evidence-badge" data-id="{{ $evidence->id }}"></span>
        @else
            <span class="badge badge-dark evidence-badge"></span>
        @endif
    @endforeach
</td>
