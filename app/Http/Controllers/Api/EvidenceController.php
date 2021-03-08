<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvidenceDestroyRequest;
use App\Http\Requests\EvidenceLinkRequest;
use App\Http\Requests\EvidenceStoreRequest;
use App\Http\Requests\EvidenceUpdateRequest;
use App\Models\Enums\EvidenceStatusEnum;
use App\Models\Evidence;
use App\Services\S3AjaxUploadService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EvidenceController extends Controller
{
    public function store(EvidenceStoreRequest $request, S3AjaxUploadService $uploadService): array
    {
        $data = $request->validated();
        $evidence = new Evidence();
        $evidence->delegation()->associate($request->contestant()->delegation);
        $evidence->status = $data['status'] ?? EvidenceStatusEnum::created();
        $evidence->type = $data['type'];
        $evidence->filename = $data['filename'];
        $evidence->save();

        $evidence->contestants()->attach($request->contestant(), [
            'delegation_id' => $request->contestant()->delegation->id,
        ]);

        $upload = $uploadService->prepareSignedUploadRequest($evidence->key);
        return [
            'evidenceId' => $evidence->id,
            'upload' => [
                'url' => $upload->getFormAttributes()['action'],
                'fields' => $upload->getFormInputs(),
            ],
        ];
    }

    public function link(EvidenceLinkRequest $request) {
        $evidence = Evidence::findOrFail($request->get('evidenceId'));
        if(!$evidence->delegation->is($request->delegation())) {
            throw new BadRequestHttpException();
        }

        try {
            $evidence->contestants()->attach($request->contestant(), ['delegation_id' => $request->delegation()->id]);
        } catch(QueryException $exception) {
            // Duplicate key error means that somebody else already has linked the evidence to the contestant - ignore it
            if ((int)$exception->getCode() !== 23505) {
                throw $exception;
            }
        }
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
        $evidence->contestants()->detach($request->contestant());

        try {
            $evidence->delete();
        } catch (QueryException $e) {
            if ((int)$e->getCode() === 23503) {
                return; // Evidence is in use for another Contestant, don't delete the file yet
            }
            throw $e;
        }

        // status might be out of sync - try to delete always
        $disk->delete($evidence->key);
    }
}
