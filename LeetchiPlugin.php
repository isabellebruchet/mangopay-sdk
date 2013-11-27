<?php

namespace Betacie\MangoPay;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LeetchiPlugin implements EventSubscriberInterface
{

    /**
     * @var string
     */
    private $privateKeyFile;

    /**
     * @var string
     */
    private $privateKeyPassphrase;

    public function __construct($privateKeyFile, $privateKeyPassphrase)
    {
        $this->privateKeyFile = $privateKeyFile;
        $this->privateKeyPassphrase = $privateKeyPassphrase;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend'),
        );
    }

    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];

        // Add ts parameter
        $queryString = $request->getQuery();
        $queryString->add('ts', time());
        
        // Add X-Leetchi-Signature to header, required for authentication
        $data = array($request->getMethod(), $request->getPath() . '?' . $request->getQuery());

        if (in_array($request->getMethod(), array('POST', 'PUT'))) {
            $data[] = $request->getBody();
        }

        $data[] = '';

        $privateKey = openssl_pkey_get_private('file://' . $this->privateKeyFile, $this->privateKeyPassphrase);

        openssl_sign(implode('|', $data), $signature, $privateKey, OPENSSL_ALGO_SHA1);

        $request->setHeader('X-Leetchi-Signature', base64_encode($signature));
    }

}
