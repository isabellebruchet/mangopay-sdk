<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Payment cards are associated to users, and are used for contributing to wallets or personal accounts.
 */
class PaymentCardRequest extends BaseRequest
{

    /**
     * Create a new PaymentCard Object
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag', 'TemplateURL',
                'OwnerID', 'ReturnURL',
                'culture',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('cards', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a PaymentCard based on an ID
     *
     * @param  integer                       $paymentCardId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($paymentCardId)
    {
        return $this->client->get('cards/' . $paymentCardId)->send();
    }

    /**
     * Remove a PaymentCard
     *
     * @param  integer                       $paymentCardId
     * @return \Guzzle\Http\Message\Response
     */
    public function delete($paymentCardId)
    {
        return $this->client->delete('cards/' . $paymentCardId)->send();
    }

}
