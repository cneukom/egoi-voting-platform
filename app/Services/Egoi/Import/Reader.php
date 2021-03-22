<?php


namespace App\Services\Egoi\Import;


use App\Services\Egoi\Import\Stubs\Stub;
use Exception;
use Generator;
use Illuminate\Support\Facades\Storage;

abstract class Reader
{
    private array $records;

    const STUB = Stub::class;

    /**
     * @param string $filename
     * @param string $disk
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct(string $filename, string $disk = 's3')
    {
        $fileContents = Storage::disk($disk)->get($filename);
        $this->records = preg_split('/[\r\n]+/', $fileContents);
        $header = str_getcsv(array_shift($this->records));
        if ($header !== array_keys((static::STUB)::FIELDS)) {
            preg_match('/[^\\\\]*$/', static::STUB, $stubName);
            throw new Exception('Invalid ' . lcfirst($stubName[0]) . ' file - headers don\'t match: ' .
                $filename . PHP_EOL .
                'have: ' . json_encode($header) . PHP_EOL .
                'want: ' . json_encode(array_keys((static::STUB)::FIELDS))
            );
        }
    }

    public function records(): Generator
    {
        foreach ($this->records as $record) {
            if (!$record) continue;
            $record = str_getcsv($record);
            yield new (static::STUB)($record);
        }
    }
}
