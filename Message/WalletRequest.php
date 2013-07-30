<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A wallet is an object in which contributions from the users are stored in order to collect money. (i.e a pool).
 * If you want to transfer money from one user to another, you need to make the transfer from one personal account to another.
 */
class WalletRequest extends BaseRequest
{

    /**
     * Create a new wallet
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'Owners',
            ))
            ->setOptional(array(
                'Tag', 'Name', 'Description',
                'RaisingGoalAmount', 'ContributionLimitDate',
            ))
            ->setAllowedTypes(array(
                'Owners' => 'array',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('wallets', null, json_encode($parameters))->send();
    }

    /**
     * Get a wallet object based on an ID
     *
     * @param  integer                       $walletId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($walletId)
    {
        return $this->client->get('wallets/' . $walletId)->send();
    }

    /**
     * Modify a wallet
     *
     * @param  update                        $walletId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function update($walletId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'Tag', 'Name', 'Description',
                'RaisongGoalAmount', 'ExpirationDate',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->put('wallets/' . $walletId, null, json_encode($parameters))->send();
    }

    /**
     * Fetch Users who participated in a given Wallet
     *
     *
     * @param  integer                       $walletId
     * @param  string                        $include  Allowed values: [owners, contributors, refunded]
     * @return \Guzzle\Http\Message\Response
     */
    public function listUsers($walletId, $include = null)
    {
        $uri = sprintf('wallets/%s/users', $walletId);

        if (in_array($include, array('owners', 'contributors', 'refunded'))) {
            $uri .= '?include=' . $include;
        }

        return $this->client->get($uri)->send();
    }

    /**
     * Fetch operations on a wallet
     *
     * @param  integer                       $walletId
     * @return \Guzzle\Http\Message\Response
     */
    public function getOperations($walletId)
    {
        return $this->client->get('wallets/' . $walletId . '/operations')->send();
    }

}
