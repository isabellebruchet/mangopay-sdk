<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A transfer is a request to send money between two personal accounts or between wallets and personal accounts.
 * At the moment, you can’t request a transfer from wallet to wallet.
 */
class TransferRequest extends BaseRequest
{

    /**
     * Create a new Tranfer Object
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'Amount',
            ))
            ->setOptional(array(
                'Tag', 'PayerID', 'BeneficiaryID',
                'ClientFeeAmount',
                'PayerWalletID', 'BeneficiaryWalletID',
            ))
            ->setAllowedTypes(array(
                'Amount' => 'integer',
                'ClientFeeAmount' => 'integer',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('transfers', null, json_encode($parameters))->send();
    }

    /**
     * Get a transfer based on an ID
     *
     * @param  integer                       $transferId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($transferId)
    {
        return $this->client->get('transfers/' . $transferId)->send();
    }

    /**
     * Refund a contribution from a personal wallet to a shared walletTransferID
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function refund(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'TransferID', 'UserID',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('transfer-refunds', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a transfer refund object based on an ID
     *
     * @param  integer                       $transferRefundId
     * @return \Guzzle\Http\Message\Response
     */
    public function getRefunds($transferRefundId)
    {
        return $this->client->get('transfer-refunds/' . $transferRefundId)->send();
    }

}
