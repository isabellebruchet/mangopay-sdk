<?php

namespace Betacie\MangoPay\Message;

class StrongAuthenticationRequest extends BaseRequest
{

    /**
     * Get all the strongAuthentication requests which need to be validated.
     * It’s important to understand that Leetchi itself may create the request of strongAuthentication,
     * if a user reaches certain predefined limits.
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function getAll()
    {
        return $this->client->get('strongAuthentication')->send();
    }

}
