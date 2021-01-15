<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvidenceDestroyRequest;
use App\Http\Requests\EvidenceStoreRequest;
use App\Http\Requests\EvidenceUpdateRequest;
use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Evidence;

class EvidenceController extends Controller
{
    public function store(EvidenceStoreRequest $request): array
    {
        $data = $request->validated();
        $evidence = new Evidence();
        $evidence->contestant()->associate($request->contestant());
        $evidence->status = $data['status'] ?? EvidenceStatusEnum::created();
        $evidence->type = $data['type'];
        $evidence->save();
        return [
            'uploadUrl' => 'about:blank', // TODO inject Upload URL
        ];
    }

    public function update(EvidenceUpdateRequest $request)
    {
        // TODO check presence in S3
        $evidence = $request->evidence();
        $evidence->status = $request->validated()['status'];
        $evidence->save();
    }

    public function destroy(EvidenceDestroyRequest $request)
    {
        // TODO delete the file in S3
        $request->evidence()->delete();
    }
}
