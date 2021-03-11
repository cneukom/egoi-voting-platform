<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read int $vote_count Consider eager loading the voteCount relations
 * @property-read Collection|OptionQuestionUser[] $voteCount
 * @property-read int|null $vote_count_count
 * @property-read Collection|User[] $voters
 * @property-read int|null $voters_count
 */
class Option extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function voters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'option_question_user');
    }

    public function voteCount(): HasMany
    {
        return $this->hasMany(OptionQuestionUser::class)
            ->groupBy('option_question_user.option_id', 'option_question_user.question_id')
            ->selectRaw('option_question_user.option_id, COUNT(*) AS vote_count');
    }

    public function getVoteCountAttribute(): int
    {
        if (!array_key_exists('voteCount', $this->relations)) $this->load('voteCount');

        $related = $this->getRelation('voteCount')->first();

        return ($related) ? $related->vote_count : 0;
    }
}
