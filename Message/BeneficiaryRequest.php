<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A beneficiary is an item who is the target of a withdrawal.
 * This object is required in order to process withdrawal requests,
 * as it contains all bank details (may also be linked to a user).
 */
class BeneficiaryRequest extends BaseRequest
{

    /**
     * Create a new Beneficiary
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'BankAccountOwnerName', 'BankAccountOwnerAddress',
                'BankAccountIBAN', 'BankAccountBIC',
            ))
            ->setOptional(array(
                'Tag', 'UserID',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('beneficiaries', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a beneficiary object based on an ID
     *
     * @param  integer                       $beneficiaryId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($beneficiaryId)
    {
        return $this->client->get('beneficiaries/' . $beneficiaryId)->send();
    }

    /**
     * Create a request of strong beneficiary authentication.
     * If a strongAuthentication object already exists for the given beneficiary, the POST request returns the existing object.
     *
     * @param  integer                       $beneficiaryId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function createStrongAuthentication($beneficiaryId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client
                ->post('beneficiaries/' . $beneficiaryId . '/strongAuthentication', null, json_encode($parameters))
                ->send();
    }

    /**
     * Fetch a strong authentication object based on a given beneficiary ID
     *
     * @param  integer                       $beneficiaryId
     * @return \Guzzle\Http\Message\Response
     */
    public function getStrongAuthentication($beneficiaryId)
    {
        return $this->client->get('beneficiaries/' . $beneficiaryId . '/strongAuthentication')->send();
    }

    /**
     * Update a strong authentication object based on a given beneficiary ID
     *
     * @param  integers                      $beneficiaryId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function updateStringAuthentication($beneficiaryId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag', 'IsDocumentsTransmitted',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client
            ->put('beneficiaries/' . $beneficiaryId . '/strongAuthentication', null, json_encode($parameters))
            ->send();
    }

}
