<?php

namespace App\Services;

use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;

class S3AjaxUploadService
{

    private S3Client $client;

    public function __construct(S3Client $client)
    {
        $this->client = $client;
    }

    public function prepareSignedUploadRequest(string $key): PostObjectV4
    {
        $formInputs = [
            'key' => $key,
        ];

        $options = [
            ['bucket' => config('filesystems.disks.s3.bucket')],
            ['starts-with', '$key', $key],
        ];

        return new PostObjectV4(
            $this->client,
            config('filesystems.disks.s3.bucket'),
            $formInputs,
            $options,
            '+1 hour'
        );
    }
}
