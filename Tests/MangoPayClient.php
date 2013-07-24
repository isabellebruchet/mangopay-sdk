<?php

namespace Betacie\MangoPay\Tests;

use Betacie\MangoPay\MangoPayClient as BaseClient;
use Betacie\MangoPay\LeetchiPlugin;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;

class MangoPayClient extends BaseClient
{

    public function __construct($items)
    {
        parent::__construct('123456789', '', '', true);

        $mock = new MockPlugin($items);
        $this->addSubscriber($mock);
        $dispatcher = $this->getEventDispatcher();
        foreach ($dispatcher->getListeners('request.before_send') as $listener) {
            if ($listener[0] instanceof LeetchiPlugin) {
                $dispatcher->removeSubscriber($listener[0]);
            }
        }
    }
    
    public static function make($responseNumber = 1)
    {
        if ($responseNumber < 1) {
            throw new \InvalidArgumentException(sprintf('You must pass a number greater than 0: "%s" given', $responseNumber));
        }
        
        $responses = array();
        
        while ($responseNumber > 0) {
            $responses[] = new Response(200);
            
            $responseNumber--;
        }
        
        return new static($responses);
    }

}
