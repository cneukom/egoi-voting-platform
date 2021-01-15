<?php


namespace App\Models;

use App\Models\Docs\ModelDocs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $code
 * @property string $access_token
 * @property-read Contestant[]|Collection $contestants
 */
class Delegation extends Model
{
    use ModelDocs;

    public function contestants(): HasMany
    {
        return $this->hasMany(Contestant::class);
    }
}
