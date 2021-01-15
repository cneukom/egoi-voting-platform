<?php


namespace App\Models;

use App\Models\Docs\ModelDocs;
use App\Models\Enums\EvidenceTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $code
 * @property string $access_token
 * @property-read Delegation $delegation
 * @property-read Evidence[]|Collection $evidence
 * @property-read Evidence[]|Collection $screenCaptures
 * @property-read Evidence[]|Collection $workScenes
 */
class Contestant extends Model
{
    use ModelDocs;

    public function delegation(): BelongsTo
    {
        return $this->belongsTo(Delegation::class);
    }

    public function screenCaptures(): HasMany
    {
        return $this->evidence()->where('type', EvidenceTypeEnum::screenCapture());
    }

    public function evidence(): HasMany
    {
        return $this->hasMany(Evidence::class);
    }

    public function workScenes(): HasMany
    {
        return $this->evidence()->where('type', EvidenceTypeEnum::workScene());
    }
}
