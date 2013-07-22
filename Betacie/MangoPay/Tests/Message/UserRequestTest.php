<?php

namespace Betacie\MangoPay\Tests\Message;

use Betacie\MangoPay\Message\UserRequest;
use Betacie\MangoPay\Tests\MangoPayClient;
use Guzzle\Http\Message\Response;

class UserRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testFetch()
    {
        $client = new MangoPayClient(array(
            new Response(200),
        ));

        $user = new UserRequest($client);

        $this->assertEquals($user->fetch(1)->getStatusCode(), 200);
    }

    public function testCreate()
    {
        $client = new MangoPayClient(array(
            new Response(200),
            new Response(200),
        ));

        $user = new UserRequest($client);

        $parameters = array(
            'Email' => 'johndoe@email.tld',
            'FirstName' => 'John',
            'LastName' => 'Doe',
            'IP' => '127.0.0.1',
            'Birthday' => '01-01-1970',
            'Nationality' => 'FR',
            'PersonType' => UserRequest::NATURAL_PERSON,
        );
        $response1 = $user->create($parameters);

        $this->assertEquals($response1->getStatusCode(), 200);

        // Optional parameters
        $parameters['Tag'] = 'New Tag';
        $parameters['CanRegisterMeanOfPayment'] = 'true';

        $response2 = $user->create($parameters);

        $this->assertEquals($response2->getStatusCode(), 200);
    }

    /**
     * @dataProvider providerCreateRequiredFields
     * @expectedException Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testCreateRequiredFields($parameters)
    {
        $client = new MangoPayClient(array(
            new Response(200),
        ));

        $user = new UserRequest($client);
        $user->create($parameters);
    }

    public function providerCreateRequiredFields()
    {
        return array(
            array(
                array(
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'IP' => '127.0.0.1',
                    'Birthday' => '01-01-1970',
                    'Nationality' => 'FR',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'LastName' => 'Doe',
                    'IP' => '127.0.0.1',
                    'Birthday' => '01-01-1970',
                    'Nationality' => 'FR',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'FirstName' => 'John',
                    'IP' => '127.0.0.1',
                    'Birthday' => '01-01-1970',
                    'Nationality' => 'FR',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'Birthday' => '01-01-1970',
                    'Nationality' => 'FR',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'IP' => '127.0.0.1',
                    'Nationality' => 'FR',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'IP' => '127.0.0.1',
                    'Birthday' => '01-01-1970',
                    'PersonType' => UserRequest::NATURAL_PERSON,
                )),
            array(
                array(
                    'Email' => 'johndoe@email.tld',
                    'FirstName' => 'John',
                    'LastName' => 'Doe',
                    'IP' => '127.0.0.1',
                    'Birthday' => '01-01-1970',
                    'Nationality' => 'FR',
                )),
        );
    }

    public function testUpdate()
    {
        $client = new MangoPayClient(array(
            new Response(200),
        ));

        $user = new UserRequest($client);

        $parameters = array(
            'Email' => 'johndoe@email.tld',
            'FirstName' => 'John',
            'LastName' => 'Doe',
            'Birthday' => '01-01-1970',
            'Nationality' => 'FR',
            'CanRegisterMeanOfPayment' => true,
            'Tag' => 'New Tag',
        );
        $response = $user->update('1', $parameters);

        $this->assertEquals($response->getStatusCode(), 200);
    }

}
