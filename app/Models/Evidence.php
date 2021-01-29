<?php


namespace App\Models;

use App\Models\Docs\ModelDocs;
use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Enums\EvidenceTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property EvidenceStatusEnum $status
 * @property EvidenceTypeEnum $type
 * @property string $filename
 * @property-read string|null $extension
 * @property-read string $key
 * @property-read Contestant $contestant
 */
class Evidence extends Model
{
    use ModelDocs;

    protected $casts = [
        'status' => EvidenceStatusEnum::class,
        'type' => EvidenceTypeEnum::class,
    ];

    public function contestant(): BelongsTo
    {
        return $this->belongsTo(Contestant::class);
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
        return $this->contestant->delegation->code . '/' . $this->contestant->code . '/' . $this->type->value . '_' . $this->id . rtrim('.' . $this->extension, '.');
    }
}
