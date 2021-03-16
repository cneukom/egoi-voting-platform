<?php


namespace App\Services\Egoi\Import;


use App\Services\Egoi\Import\Stubs\Stub;
use Exception;
use Generator;

abstract class Reader
{
    private $file;

    const STUB = Stub::class;

    /**
     * @param string $filename
     * @throws Exception
     */
    public function __construct(string $filename)
    {
        $this->file = fopen($filename, 'r');
        $header = fgetcsv($this->file);
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
        while (!feof($this->file)) {
            $row = fgetcsv($this->file);
            if (!$row) continue;
            yield new (static::STUB)($row);
        }
        fclose($this->file);
    }
}
