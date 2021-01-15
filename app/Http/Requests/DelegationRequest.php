<?php

namespace App\Http\Requests;

use App\Models\Delegation;
use Illuminate\Foundation\Http\FormRequest;

class DelegationRequest extends FormRequest
{
    public function authorize()
    {
        return $this->delegation()->access_token === $this->route()->parameter('token');
    }

    public function delegation(): Delegation
    {
        $delegation = $this->route()->parameter('delegation');
        if (!$delegation instanceof Delegation) {
            $delegation = Delegation::findOrFail($delegation);
        }
        return $delegation;
    }

    public function rules()
    {
        return [];
    }
}
