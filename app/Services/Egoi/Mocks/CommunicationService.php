<?php


namespace App\Services\Egoi\Mocks;


use App\Services\Egoi\Contracts\CommunicationService as CommunicationServiceInterface;

class CommunicationService implements CommunicationServiceInterface
{
    public function sendMessage(?string $channelType, ?string $delegationId, string $message)
    {
        if($channelType === null) {
            $channelType = 'all';
        }
        if($delegationId === null) {
            $delegationId = 'ALL';
        }
        error_log('MSG to [' . strtoupper($delegationId) . '-' . strtolower($channelType) . '] "' . $message . '"');
    }
}
