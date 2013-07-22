<?php

namespace Betacie\MangoPay\Tests\Message;

use Betacie\MangoPay\Message\RecurrentContributionRequest;
use Betacie\MangoPay\Tests\MangoPayClient;

class RecurrentContributionRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $message = $this->getMessage();

        $response = $message->create(array(
            'Amount' => 100,
            'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
            'NumberOfExecutions' => 1,
            'ReturnURL' => 'http://localhost.tld',
            'StartDate' => time(),
            'UserID' => 1,
            'WalletID' => 1,
        ));

        $this->assertSame(0, strpos($response->getEffectiveUrl(), 'http://api-preprod.leetchi.com/v1/partner/123456789/recurrent-contributions?ts='));
    }

    /**
     * @dataProvider providerCreateRequiredFields
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testCreateRequiredFields($parameters)
    {
        $message = $this->getMessage();

        $message->create($parameters);
    }

    public function providerCreateRequiredFields()
    {
        return array(
            array(
                array(
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'NumberOfExecutions' => 1,
                    'ReturnURL' => 'http://localhost.tld',
                    'StartDate' => time(),
                    'UserID' => 1,
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'NumberOfExecutions' => 1,
                    'ReturnURL' => 'http://localhost.tld',
                    'StartDate' => time(),
                    'UserID' => 1,
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'ReturnURL' => 'http://localhost.tld',
                    'StartDate' => time(),
                    'UserID' => 1,
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'NumberOfExecutions' => 1,
                    'StartDate' => time(),
                    'UserID' => 1,
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'NumberOfExecutions' => 1,
                    'ReturnURL' => 'http://localhost.tld',
                    'UserID' => 1,
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'NumberOfExecutions' => 1,
                    'ReturnURL' => 'http://localhost.tld',
                    'StartDate' => time(),
                    'WalletID' => 1,
                )
            ),
            array(
                array(
                    'Amount' => 100,
                    'FrequencyCode' => RecurrentContributionRequest::FREQUENCY_WEEKLY,
                    'NumberOfExecutions' => 1,
                    'ReturnURL' => 'http://localhost.tld',
                    'StartDate' => time(),
                    'UserID' => 1,
                )
            ),
        );
    }

    public function testFetch()
    {
        $message = $this->getMessage();

        $response = $message->fetch('123');

        $this->assertSame(0, strpos($response->getEffectiveUrl(), 'http://api-preprod.leetchi.com/v1/partner/123456789/recurrent-contributions/123?ts='));
    }

    public function testUpdate()
    {
        $message = $this->getMessage();

        $response = $message->update('123', array('IsEnabled' => true));

        $this->assertSame(0, strpos($response->getEffectiveUrl(), 'http://api-preprod.leetchi.com/v1/partner/123456789/recurrent-contributions/123?ts='));
    }

    public function testGetExecutions()
    {
        $message = $this->getMessage();

        $response = $message->getExecutions('123');

        $this->assertSame(0, strpos($response->getEffectiveUrl(), 'http://api-preprod.leetchi.com/v1/partner/123456789/recurrent-contributions/123/executions?ts='));
    }

    public function testGetFrequencyCodes()
    {
        $this->assertEquals(RecurrentContributionRequest::getFrequencyCodes(), array(
            'Daily', 'Weekly', 'TwiceMonthly', 'Monthly', 'Bimonthly', 'Quaterly', 'Annual', 'Biannual',
        ));
    }

    public function getMessage($responseNumber = 1)
    {
        $client = MangoPayClient::make($responseNumber);

        return new RecurrentContributionRequest($client);
    }

}
