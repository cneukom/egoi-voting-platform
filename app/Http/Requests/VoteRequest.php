<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Question $question
 */
class VoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !$this->user()->is_admin
            && !$this->user()->hasParticipated($this->question)
            && $this->question->closes_at->isFuture();
    }

    public function rules(): array
    {
        return [
            'option' => [
                'required',
                Rule::exists('options', 'id')->where(function (Builder $query) {
                    return $query->where('question_id', $this->question->id);
                }),
            ],
        ];
    }
}
