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
        $validated['closes_at'] = now()
            // round up current minute, to close at a full minute while providing at least the requested voting duration
            ->addSeconds(30)->roundMinute()
            ->addMinutes($validated['duration']);
        return $validated;
    }
}
