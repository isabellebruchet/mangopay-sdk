<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A refund is a request to cancel a contribution in order to transfer money
 * which has already been paid back to a user’s bank account.
 */
class RefundRequest extends BaseRequest
{

    /**
     * Create a refund request for a contribution.
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'ContributionID', 'UserID',
            ))
            ->setOptional(array(
                'Tag',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('refunds', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a refund object based on an ID
     *
     * @param  integer                       $refundId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($refundId)
    {
        return $this->client->get('refunds/' . $refundId)->send();
    }

}
