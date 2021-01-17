<?php

namespace App\Console\Commands;

use Aws\S3\S3Client;
use Illuminate\Console\Command;

class PurgeBucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bucket:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all files in the bucket';

    public function handle(S3Client $client): int
    {
        $result = $client->listObjects([
            'Bucket' => config('filesystems.disks.s3.bucket'),
        ]);
        if($result->hasKey('Contents')) {
            foreach ($result->get('Contents') as $object) {
                $result = $client->deleteObject([
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                    'Key' => $object['Key'],
                ]);
            }
            $this->output->success('Deleted all objects from bucket');
        } else {
            $this->warn('Bucket already empty');
        }
        return 0;
    }
}
