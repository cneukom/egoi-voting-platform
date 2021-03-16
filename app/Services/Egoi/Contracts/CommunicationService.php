<?php


namespace App\Services\Egoi\Contracts;


interface CommunicationService
{
    const CHANNEL_TYPE_ALL = null;
    const CHANNEL_TYPE_PROCTORS = 'proc';
    const CHANNEL_TYPE_LEADERS = 'lead';
    const CHANNEL_TYPE_TRANSLATORS = 'trans';

    public function sendMessage(?string $channelType, ?string $delegationId, string $message);
}
