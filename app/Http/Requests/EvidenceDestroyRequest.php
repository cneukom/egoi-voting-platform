<?php

namespace App\Http\Requests;

class EvidenceDestroyRequest extends EvidenceRequest
{
    public function authorize(): bool
    {
        if (!parent::authorize()) {
            return false;
        }

        // Only delegation leaders can destroy Evidence
        return $this->delegation() !== null;
    }
}