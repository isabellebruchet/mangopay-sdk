<?php

namespace Betacie\MangoPay;

use Guzzle\Http\Client;

class MangoPayClient extends Client
{

    public function __construct($partnerId, $privateKeyFile, $privateKeyPassphrase, $debug = false)
    {
        $baseUrl = $debug
            ? 'http://api-preprod.leetchi.com/v1/partner/{partnerId}/'
            : 'https://api.leetchi.com/v1/partner/{partnerId}/';

        parent::__construct($baseUrl, array(
            'partnerId' => $partnerId,
            'request.options' => array(
                'headers' => array('Content-Type' => 'application/json'),
                'query' => array('ts' => time()),
            )
        ));

        $leetchi = new LeetchiPlugin($privateKeyFile, $privateKeyPassphrase);
        $this->addSubscriber($leetchi);
    }

}
