<?php

namespace Betacie\MangoPay\Message;

use Betacie\MangoPay\MangoPayClient;

class BaseRequest
{

    /**
     * @var MangoPayClient
     */
    protected $client;

    public function __construct(MangoPayClient $client)
    {
        $this->client = $client;
    }

}
