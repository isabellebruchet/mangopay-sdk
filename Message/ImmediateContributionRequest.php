<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * An immediate contribution is a request to process directly a payment with a payment card already registred by the user.
 */
class ImmediateContributionRequest extends BaseRequest
{

    /**
     * Create an immediate contribution to deposit money on a wallet.
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'UserID', 'WalletID',
                'Amount', 'PaymentCardID',
            ))
            ->setOptional(array(
                'Tag', 'ClientFeeAmount',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('immediate-contributions', null, json_encode($parameters))->send();
    }

    /**
     * Fetch an immediate contribution object based on an ID
     *
     * @param  integer                       $immediateContributionId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($immediateContributionId)
    {
        return $this->client->get('immediate-contributions/' . $immediateContributionId)->send();
    }

}
