<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A withdrawal is a request to transfer money from a wallet or a personal account to a bank account.
 * You need to setup beneficiary information before you may process a withdrawal.
 */
class WithdrawalRequest extends BaseRequest
{

    /**
     * Create a new Withdrawal Object
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'UserID', 'WalletID', 'BeneficiaryID',
                'Amount',
                'ClientFeeAmount', 'Tag',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('withdrawals', null, json_encode($parameters))->send();
    }

    /**
     * Get a withdrawal based on an ID
     *
     * @param  integer                       $withdrawalId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($withdrawalId)
    {
        return $this->client->get('withdrawals/' . $withdrawalId)->send();
    }

}
