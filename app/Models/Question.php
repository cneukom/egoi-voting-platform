<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property string $question
 * @property string $information
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon $closes_at
 * @method static Builder|Question newModelQuery()
 * @method static Builder|Question newQuery()
 * @method static Builder|Question query()
 * @method static Builder|Question whereClosesAt($value)
 * @method static Builder|Question whereCreatedAt($value)
 * @method static Builder|Question whereId($value)
 * @method static Builder|Question whereInformation($value)
 * @method static Builder|Question whereQuestion($value)
 * @method static Builder|Question whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Option[] $options
 * @property-read int|null $options_count
 * @property-read Collection|User[] $participatingUsers
 * @property-read int|null $participating_users_count
 * @method static Builder|Question closed()
 * @method static Builder|Question open()
 * @property-read Option|null $selected_option Don't use this without eager loading the options.voteCount relation!
 * @property-read int $total_votes Don't use this without eager loading the options.voteCount relation!
 * @method static Builder|Question didntVote(User $user)
 * @method static Builder|Question hasVoted(User $user)
 */
class Question extends Model
{
    use HasFactory;

    protected $dates = [
        'closes_at',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    private bool $isSelectedOptionCached = false;
    private ?Option $selectedOption;

    public function getSelectedOptionAttribute(): ?Option
    {
        if (!$this->isSelectedOptionCached) {
            $this->isSelectedOptionCached = true;

            $this->selectedOption = null;
            $voteCount = -1;
            $isTie = false;
            foreach ($this->options as $option) {
                if ($option->vote_count > $voteCount) {
                    $this->selectedOption = $option;
                    $voteCount = $option->vote_count;
                    $isTie = false;
                } elseif ($option->vote_count == $voteCount) {
                    $isTie = true;
                }
            }

            if ($isTie) {
                $this->selectedOption = null;
            }
        }
        return $this->selectedOption;
    }

    private bool $isTotalVotesCached = false;
    private int $totalVotes = 0;

    /**
     * The number of votes handed in for this Question.
     *
     * This is currently only be used in combination with the options.voteCount relation, hence we aggregate over this
     * relation. A future optimization could add direct voteCount relation and then choose a relation that is available
     * here.
     *
     * @return int
     */
    public function getTotalVotesAttribute(): int
    {
        if (!$this->isTotalVotesCached) {
            $this->isTotalVotesCached = true;

            foreach ($this->options as $option) {
                $this->totalVotes += $option->vote_count;
            }
        }
        return $this->totalVotes;
    }

    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'option_question_user');
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('closes_at', '>', now());
    }

    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('closes_at', '<=', now());
    }

    public function scopeHasVoted(Builder $query, User $user): Builder
    {
        return $query->whereHas('participatingUsers', function(Builder $query) use ($user) {
            return $query->where('user_id', $user->id);
        });
    }

    public function scopeDidntVote(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('participatingUsers', function(Builder $query) use ($user) {
            return $query->where('user_id', $user->id);
        });
    }
}
