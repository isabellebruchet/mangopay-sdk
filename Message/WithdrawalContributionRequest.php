<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A withdrawal contribution is a request to process a wire transfer (minimum 200 €)
 * to a wallet or to a personal account for a dedicated user.
 */
class WithdrawalContributionRequest extends BaseRequest
{

    const STATUS_CREATED = 'CREATED';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_REFUSED = 'REFUSED';

    /**
     * Create a new WithdrawalContribution Object
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'UserID', 'AmountDeclared',
            ))
            ->setOptional(array(
                'Tag', 'WalletID',
            ))
            ->setAllowedTypes(array(
                'AmountDeclared' => 'integer',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('contributions-by-withdrawal', null, json_encode($parameters))->send();
    }

    /**
     * Get a WithdrawContribution base on an ID
     *
     * @param  integer                       $withdrawalContributionId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($withdrawalContributionId)
    {
        return $this->client->get('contributions-by-withdrawal/' . $withdrawalContributionId)->send();
    }

    /**
     * Get all allowed status code
     *
     * @return array
     */
    public static function getStatusCodes()
    {
        $codes = array();

        $reflectionClass = new \ReflectionClass(__CLASS__);
        foreach ($reflectionClass->getConstants() as $constant => $value) {
            if (0 === strpos($constant, 'STATUS_')) {
                $codes[] = $value;
            }
        }

        return $codes;
    }

}
