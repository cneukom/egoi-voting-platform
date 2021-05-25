<?php


namespace App\Services\Egoi\Contracts;


interface CommunicationService
{
    const CHANNEL_TYPE_ALL = null;
    const CHANNEL_TYPE_PROCTORS = 'proctors';
    const CHANNEL_TYPE_LEADERS = 'leaders';
    const CHANNEL_TYPE_TRANSLATORS = 'translators';

    public function sendMessage(?string $channelType, ?string $delegationId, string $message);
}
