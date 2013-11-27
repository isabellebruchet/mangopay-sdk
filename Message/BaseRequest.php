<?php

namespace Betacie\MangoPay\Message;

use Guzzle\Http\Client;

class BaseRequest
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

}
