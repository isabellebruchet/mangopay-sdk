<?php

namespace Betacie\MangoPay\Message;

/**
 * A contribution is a request to process a payment (CB/VISA/MASTERCARD, ELV, SOFORTÜBERWEISUNG, GIROPAY and AMEX)
 * to a wallet or to a personal account for a dedicated user.
 */
class ContributionRequest extends BaseRequest
{

    /**
     * Create a contribution in order to deposit money to the wallet.
     * <strong>Note:</strong> To make a contribution to a user personal wallet, pass WalletID with the value “0"
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        return $this->client->post('contributions', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a contribution object based on an ID
     *
     * @param  integer                       $contributionId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($contributionId)
    {
        return $this->client->get('contributions/' . $contributionId)->send();
    }

}
