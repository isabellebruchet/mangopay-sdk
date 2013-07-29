<?php

namespace Betacie\MangoPay\Message;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * A recurrent contribution is set in order to perform contributions at a given frequency.
 *
 * If a payment is refused on its due date, there will be two new attempts, each two days later.
 * If the payment is still refused at the third attempt, the transaction is considered as refused.
 */
class RecurrentContributionRequest extends BaseRequest
{

    const FREQUENCY_DAILY = 'Daily';
    const FREQUENCY_WEEKLY = 'Weekly';
    const FREQUENCY_TWICE_MONTHLY = 'TwiceMonthly';
    const FREQUENCY_MONTHLY = 'Monthly';
    const FREQUENCY_BIMONTHLY = 'Bimonthly';
    const FREQUENCY_QUATERLY = 'Quaterly';
    const FREQUENCY_ANNUAL = 'Annual';
    const FREQUENCY_Biannual = 'Biannual';

    /**
     * Create a new RecurrentContribution
     *
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function create(array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setOptional(array(
                'UserID', 'WalletID',
                'Amount', 'ReturnURL',
                'StartDate', 'FrequencyCode', 'NumberOfExecutions',
                'Tag', 'TemplateURL', 'ClientFeeAmount',
            ))
            ->setAllowedValues(array(
                'FrequencyCode' => self::getFrequencyCodes(),
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->post('recurrent-contributions', null, json_encode($parameters))->send();
    }

    /**
     * Get a RecurrentContribution based on an ID
     *
     * @param  integer                       $recurrentContributionId
     * @return \Guzzle\Http\Message\Response
     */
    public function fetch($recurrentContributionId)
    {
        return $this->client->get('recurrent-contributions/' . $recurrentContributionId)->send();
    }

    /**
     * Modify a RecurrentContribution
     *
     * @param  integer                       $recurrentContributionId
     * @param  array                         $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function update($recurrentContributionId, array $parameters)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(array(
                'IsEnabled',
            ))
            ->setOptional(array(
                'Tag',
            ))
            ->setAllowedTypes(array(
                'IsEnabled' => 'bool',
            ))
        ;

        $parameters = $resolver->resolve($parameters);

        return $this->client->put('recurrent-contributions/' . $recurrentContributionId, null, json_encode($parameters))->send();
    }

    /**
     * Fetch a list of Payment Executions from a given Recurrent Contribution ID
     *
     * @param  integer                       $recurrentContributionId
     * @return \Guzzle\Http\Message\Response
     */
    public function getExecutions($recurrentContributionId)
    {
        return $this->client->get('recurrent-contributions/' . $recurrentContributionId . '/executions')->send();
    }

    /**
     * Get all allowed frequency codes
     *
     * @return array
     */
    public static function getFrequencyCodes()
    {
        $codes = array();

        $reflectionClass = new \ReflectionClass(__CLASS__);
        foreach ($reflectionClass->getConstants() as $constant => $value) {
            if (0 === strpos($constant, 'FREQUENCY_')) {
                $codes[] = $value;
            }
        }

        return $codes;
    }

}
