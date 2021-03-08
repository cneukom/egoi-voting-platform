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
 * @property string $closes_at
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
 */
class Question extends Model
{
    use HasFactory;

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function participatingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'option_question_user');
    }
}
