<?php

namespace App\Http\Requests;

use App\Models\Contestant;
use App\Models\Delegation;
use App\Models\Evidence;
use Illuminate\Foundation\Http\FormRequest;

class EvidenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * EvidenceRequests are authorized, if the $token matches the delegation and the Contestant belongs to the
     * Delegation, or if the token matches the Contestant. Furthermore, if the Request targets specific Evidence,
     * the Evidence must belong the the Contestant.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $token = $this->route()->parameter('token');

        if ($this->evidence()) { // if present, Evidence must belong to the Contestant
            if (!$this->evidence()->contestants()->find($this->contestant())) {
                return false;
            }
        }

        if ($this->delegation()) { // check delegation token and contestant's affiliation
            if ($this->delegation()->access_token === $token && $this->delegation()->is($this->contestant()->delegation)) {
                return true;
            }
        } else { // check contestant token
            if ($this->contestant()->access_token === $token) {
                return true;
            }
        }
        return false;
    }

    public function evidence(): ?Evidence
    {
        $evidence = $this->route()->parameter('evidence');
        if ($evidence && !$evidence instanceof Evidence) {
            $evidence = Evidence::findOrFail($evidence);
        }
        return $evidence;
    }

    public function contestant(): Contestant
    {
        $contestant = $this->route()->parameter('contestant');
        if (!$contestant instanceof Contestant) {
            $contestant = Contestant::findOrFail($contestant);
        }
        return $contestant;
    }

    public function delegation(): ?Delegation
    {
        $delegation = $this->route()->parameter('delegation');
        if ($delegation && !$delegation instanceof Delegation) {
            $delegation = Delegation::findOrFail($delegation);
        }
        return $delegation;
    }

    public function rules(): array
    {
        return [];
    }
}
