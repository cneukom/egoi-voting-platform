<?php

namespace App\Http\Requests;

use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Enums\EvidenceTypeEnum;
use Illuminate\Validation\Rule;

class EvidenceStoreRequest extends EvidenceRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                Rule::in(EvidenceTypeEnum::toValues()),
            ],
            'filename' => 'required|string',
            'status' => [
                Rule::in([EvidenceStatusEnum::created()->value]),
            ],
        ];
    }
}
