<?php

namespace App\Http\Requests;

class EvidenceLinkRequest extends EvidenceRequest
{
    public function authorize(): bool
    {
        if (!parent::authorize()) {
            return false;
        }

        // Only delegation leaders can link Evidence to other participants
        return $this->delegation() !== null;
    }
}
