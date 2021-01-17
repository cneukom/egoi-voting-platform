<?php

namespace App\Console\Commands;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Console\Command;

class InitializeBucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bucket:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configures CORS on the S3 bucket';

    public function handle(S3Client $client): int
    {
        $client->putBucketCors([
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'CORSConfiguration' => [
                'CORSRules' => [
                    [
                        "AllowedMethods" => [
                            "PUT",
                            "POST",
                        ],
                        "AllowedOrigins" => [
                            "*"
                        ],
                        "AllowedHeaders" => [
                            "*"
                        ],
                    ],
                ],
            ],
        ]);

        $this->output->success('Configured CORS on bucket "' . config('filesystems.disks.s3.bucket') . '"');
        return 0;
    }
}
