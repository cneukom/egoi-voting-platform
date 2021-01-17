<?php

namespace App\View\Components;

use App\Models\Enums\EvidenceTypeEnum;
use App\Models\Evidence;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class EvidenceWidget extends Component
{
    /** @var Evidence[] */
    public Collection|array $evidences;
    public string $inputId;
    public EvidenceTypeEnum $evidenceType;

    public function __construct($evidences, EvidenceTypeEnum $type)
    {
        $this->evidences = $evidences;
        $this->evidenceType = $type;
        $this->inputId = 'input' . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.evidence-widget', [
            'evidences' => $this->evidences,
        ]);
    }
}
