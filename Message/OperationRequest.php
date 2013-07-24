<?php

namespace Betacie\MangoPay\Message;

/**
 * An operation is a request to get successful operations history for a user or a wallet.
 */
class OperationRequest extends BaseRequest
{

    /**
     * Get an operation
     *
     * @param  integer                       $operationId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($operationId)
    {
        return $this->client->get('operations/' . $operationId)->send();
    }

}
