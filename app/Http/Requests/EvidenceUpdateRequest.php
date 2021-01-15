<?php

namespace App\Http\Requests;

use App\Models\Enums\EvidenceStatusEnum;
use Illuminate\Validation\Rule;

class EvidenceUpdateRequest extends EvidenceRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in([EvidenceStatusEnum::present()->value]),
            ],
        ];
    }
}
