<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->is_admin ?? false;
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'information' => 'nullable|string',
            'duration' => 'int|min:0',
            'options' => 'array|required|min:2',
            'options.*' => 'string',
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        $validated['closes_at'] = now()->addMinutes($validated['duration']);
        return $validated;
    }
}
