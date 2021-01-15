<?php

namespace App\View\Components;

use App\Models\Evidence;
use Illuminate\View\Component;

class EvidenceWidget extends Component
{
    /** @var Evidence[] */
    public $evidences;

    public function __construct($evidences)
    {
        $this->evidences = $evidences;
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
