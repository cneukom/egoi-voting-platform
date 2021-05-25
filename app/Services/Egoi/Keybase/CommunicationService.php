<?php


namespace App\Services\Egoi\Keybase;


use App\Services\Egoi\Contracts\CommunicationService as CommunicationServiceInterface;
use Messaging\MessagingClient;
use Messaging\SendRequest;

class CommunicationService implements CommunicationServiceInterface
{
    private MessagingClient $client;

    public function __construct(MessagingClient $client)
    {
        $this->client = $client;
    }

    public function sendMessage(?string $channelType, ?string $delegationId, string $message)
    {
        if ($channelType === null) {
            $channelType = 'all';
        }
        if ($delegationId === null) {
            $delegationId = 'ALL';
        }
        $req = new SendRequest();
        $req->setMessage($message);
        $req->setTo(strtolower($delegationId) . '.' . $channelType);
        $result = $this->client->Send($req)->wait();
        if ($result[1]->code !== 0) {
            dump($result);
            throw new \Exception('Could not send message');
        }
    }
}
