<?php


namespace App\Models;

use App\Models\Docs\ModelDocs;
use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Enums\EvidenceTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property EvidenceStatusEnum $status
 * @property EvidenceTypeEnum $type
 * @property string $filename
 * @property-read string|null $extension
 * @property-read string $key
 * @property-read Delegation $delegation
 * @property-read Collection|Contestant[] $contestants
 */
class Evidence extends Model
{
    use ModelDocs;

    protected $casts = [
        'status' => EvidenceStatusEnum::class,
        'type' => EvidenceTypeEnum::class,
    ];

    public function delegation(): BelongsTo
    {
        return $this->belongsTo(Delegation::class);
    }

    public function contestants(): BelongsToMany
    {
        return $this->belongsToMany(Contestant::class);
    }

    public function getExtensionAttribute(): ?string
    {
        if (preg_match('/\.([^.]+)$/', $this->filename, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getKeyAttribute(): string
    {
        return $this->delegation->code . '/'. $this->type->value . '_' . $this->id . rtrim('.' . $this->extension, '.');
    }
}
