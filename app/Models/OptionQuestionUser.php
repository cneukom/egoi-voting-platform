<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\OptionQuestionUser
 *
 * @property int $question_id
 * @property int $user_id
 * @property int $option_id
 * @method static Builder|OptionQuestionUser newModelQuery()
 * @method static Builder|OptionQuestionUser newQuery()
 * @method static Builder|OptionQuestionUser query()
 * @method static Builder|OptionQuestionUser whereOptionId($value)
 * @method static Builder|OptionQuestionUser whereQuestionId($value)
 * @method static Builder|OptionQuestionUser whereUserId($value)
 * @mixin Eloquent
 */
class OptionQuestionUser extends Pivot
{
}
