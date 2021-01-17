<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvidenceDestroyRequest;
use App\Http\Requests\EvidenceStoreRequest;
use App\Http\Requests\EvidenceUpdateRequest;
use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Evidence;
use App\Services\S3AjaxUploadService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EvidenceController extends Controller
{
    public function view(Evidence $evidence, Filesystem $disk)
    {
        return [
            'url' => $disk->temporaryUrl($evidence->key, now()->addHour())
        ];
    }

    public function store(EvidenceStoreRequest $request, S3AjaxUploadService $uploadService): array
    {
        $data = $request->validated();
        $evidence = new Evidence();
        $evidence->contestant()->associate($request->contestant());
        $evidence->status = $data['status'] ?? EvidenceStatusEnum::created();
        $evidence->type = $data['type'];
        $evidence->filename = $data['filename'];
        $evidence->save();

        $upload = $uploadService->prepareSignedUploadRequest($evidence->key);
        return [
            'evidenceId' => $evidence->id,
            'upload' => [
                'url' => $upload->getFormAttributes()['action'],
                'fields' => $upload->getFormInputs(),
            ],
        ];
    }

    public function update(EvidenceUpdateRequest $request, Filesystem $disk)
    {
        $evidence = $request->evidence();
        $evidence->status = $request->validated()['status'];
        if ($evidence->status->equals(EvidenceStatusEnum::present())) {
            // check presence in S3 bucket
            if (!$disk->exists($evidence->key)) {
                throw new BadRequestHttpException('File not yet present in S3');
            }
        }
        $evidence->save();
    }

    public function destroy(EvidenceDestroyRequest $request, Filesystem $disk)
    {
        $evidence = $request->evidence();
        $evidence->delete();

        // status might be out of sync - try to delete always
        $disk->delete($evidence->key);
    }
}
