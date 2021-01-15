<?php

namespace App\Http\Requests;

class EvidenceDestroyRequest extends EvidenceRequest
{
    public function authorize(): bool
    {
        // Only delegation leaders can destroy Evidence
        return $this->delegation() !== null;
    }
}
