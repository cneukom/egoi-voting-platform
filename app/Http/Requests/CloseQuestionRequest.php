<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Question $question
 */
class CloseQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin
            && $this->question->participatingUsers()->count() == User::whereIsAdmin(false)->count()
            && $this->question->closes_at->isFuture();
    }

    public function rules(): array
    {
        return [];
    }
}
