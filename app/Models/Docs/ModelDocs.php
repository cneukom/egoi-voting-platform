<?php


namespace App\Models\Docs;

use Carbon\Carbon;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
trait ModelDocs
{
    use TightModelDocs;
}
