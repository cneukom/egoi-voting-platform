<?php


namespace App\Services\Egoi\Import;


use App\Services\Egoi\Import\Stubs\Delegation;

/**
 * @method Delegation[] records()
 */
class DelegationReader extends Reader
{
    const STUB = Delegation::class;
}
