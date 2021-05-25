<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Messaging;

/**
 * Service Messaging implements operations for working with keybase channels
 */
class MessagingClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Send sends a message to a Keybase channel
     * @param \Messaging\SendRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Send(\Messaging\SendRequest $argument,
                         $metadata = [], $options = []) {
        return $this->_simpleRequest('/messaging.Messaging/Send',
        $argument,
        ['\Messaging\SendResponse', 'decode'],
        $metadata, $options);
    }

}
