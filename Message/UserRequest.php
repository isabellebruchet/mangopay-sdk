<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A user may be a “natural person” or a “legal personality” and is used to process payments or transfers,
 * send withdrawals, create wallets…
 *
 * Note that once you create a user, they automatically have their own e-money account associated to their ID.
 * It is not necessary to create an additional e-wallet.
 */
class UserRequest extends BaseRequest
{

    const NATURAL_PERSON = 'NATURAL_PERSON';
    const LEGAL_PERSONALITY = 'LEGAL_PERSONALITY';

    /**
     * Create an user
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'Email', 'FirstName', 'LastName',
                'IP', 'Birthday', 'Nationality', 'PersonType',
            ))
            ->setOptional(array(
                'Tag', 'CanRegisterMeanOfPayment',
            ))
            ->setAllowedValues(array(
                'PersonType' => array(self::LEGAL_PERSONALITY, self::NATURAL_PERSON),
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('users', null, json_encode($parameters))->send();
    }

    /**
     * Fetch an user based on an ID
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($userId)
    {
        return $this->client->get('users/' . $userId)->send();
    }

    /**
     * Modify an user
     *
     * @param  integer                       $userId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function update($userId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Email', 'FirstName', 'LastName',
                'Birthday', 'Nationality',
                'Tag', 'CanRegisterMeanOfPayment',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->put('users/' . $userId, null, json_encode($parameters))->send();
    }

    /**
     * Fetch a list of wallets from a given User
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function getWallets($userId)
    {
        return $this->client->get('users/' . $userId . '/wallets')->send();
    }

    /**
     * Fetch a list of cards from a given User
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function getCards($userId)
    {
        return $this->client->get('users/' . $userId . '/cards')->send();
    }

    /**
     * Create a request of strong user authentication.
     * If a strongAuthentication object already exists for the given user, the POST request returns the existing object.
     *
     * @param  integer                       $userId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function createStrongAuthentication($userId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('users/' . $userId . '/strongAuthentication', null, json_encode($parameters))->send();
    }

    /**
     * Fetch a strong authentication object based on a given user ID
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function getStrongAuthentication($userId)
    {
        return $this->client->get('users/' . $userId . '/strongAuthentication')->send();
    }

    /**
     * Update a strong authentication object based on a given user ID
     *
     * @param  integer                       $userId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function updateStringAuthentication($userId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag', 'IsDocumentsTransmitted',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->put('users/' . $userId . '/strongAuthentication', null, json_encode($parameters))->send();
    }

    /**
     * Fetch operations associated with a user.
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function getOperations($userId)
    {
        return $this->client->get('users/' . $userId . '/operations')->send();
    }

    /**
     * Fetch operations on a personal account.
     *
     * @param  integer                       $userId
     * @return \Guzzle\Http\Message\Response
     */
    public function getPersonalAccountOperations($userId)
    {
        return $this->client->get('users/' . $userId . '/operations/personal')->send();
    }

}
