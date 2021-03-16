<?php


namespace App\Services\Egoi\Import;


use App\Services\Egoi\Import\Stubs\Participant;

/**
 * @method Participant[] records()
 */
class ParticipantReader extends Reader
{
    const STUB = Participant::class;
}
