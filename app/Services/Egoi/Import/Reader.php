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
    public function __construct(string $filename, string $disk = 'config')
    {
        $fileContents = Storage::disk($disk)->get($filename);
        $this->records = $this->csvToArray($fileContents);
        $header = array_shift($this->records);
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
            yield new (static::STUB)($record);
        }
    }

    // Taken from https://stackoverflow.com/questions/1269562/how-to-create-an-array-from-a-csv-file-using-php-and-the-fgetcsv-function
    // @author: Klemen Nagode
    private function csvToArray($string, $separatorChar = ',', $enclosureChar = '"', $newlineChar = PHP_EOL)
    {
        $array = array();
        $size = strlen($string);
        $columnIndex = 0;
        $rowIndex = 0;
        $fieldValue = "";
        $isEnclosured = false;

        for ($i = 0; $i < $size; $i++) {
            $char = $string[$i];
            $addChar = "";

            if ($isEnclosured) {
                if ($char == $enclosureChar) {
                    if ($i + 1 < $size && $string[$i + 1] == $enclosureChar) {
                        // escaped char
                        $addChar = $char;
                        $i++; // dont check next char
                    } else {
                        $isEnclosured = false;
                    }
                } else {
                    $addChar = $char;
                }
            } else {
                if ($char == $enclosureChar) {
                    $isEnclosured = true;
                } else {
                    if ($char == $separatorChar) {
                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue = "";
                        $columnIndex++;
                    } elseif ($char == $newlineChar) {
                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue = "";
                        $columnIndex = 0;
                        $rowIndex++;
                    } else {
                        $addChar = $char;
                    }
                }
            }
            if ($addChar != "") {
                $fieldValue .= $addChar;
            }
        }

        if ($fieldValue) { // save last field
            $array[$rowIndex][$columnIndex] = $fieldValue;
        }
        return $array;
    }
}
