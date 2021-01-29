<?php

namespace App\Http\Controllers;

use App\Http\Requests\DelegationRequest;
use App\Models\Delegation;
use App\Models\Evidence;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvidenceController extends Controller
{
    public function index(DelegationRequest $request)
    {
        return view('delegation', [
            'delegation' => $request->delegation(),
        ]);
    }

    public function overview()
    {
        return view('overview', [
            'delegations' => Delegation::query()
                ->orderBy('name')
                ->with([
                    'contestants' => fn(HasMany $query) => $query->orderBy('name'),
                    'contestants.screenCaptures' => fn(HasMany $query) => $query->orderBy('id'),
                    'contestants.workScenes' => fn(HasMany $query) => $query->orderBy('id'),
                ])
                ->get(),
        ]);
    }

    public function screen(Evidence $evidence, Filesystem $disk)
    {
        return view('screen', [
            'evidenceUrl' => $disk->temporaryUrl($evidence->key, now()->addHour()),
        ]);
    }
}
