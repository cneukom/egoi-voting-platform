<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Option
 *
 * @property int $id
 * @property int $question_id
 * @property string $label
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Option newModelQuery()
 * @method static Builder|Option newQuery()
 * @method static Builder|Option query()
 * @method static Builder|Option whereCreatedAt($value)
 * @method static Builder|Option whereId($value)
 * @method static Builder|Option whereLabel($value)
 * @method static Builder|Option whereQuestionId($value)
 * @method static Builder|Option whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Question $question
 */
class Option extends Model
{
    use HasFactory;

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
