<?php

namespace Betacie\MangoPay\Tests\Message;

use Betacie\MangoPay\Message\WithdrawalContributionRequest;

class WithdrawalContributionRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testGetStatusCodes()
    {
        $this->assertEquals(WithdrawalContributionRequest::getStatusCodes(), array(
            'CREATED', 'ACCEPTED', 'REFUSED',
        ));
    }

}
