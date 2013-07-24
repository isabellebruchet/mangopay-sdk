<?php

namespace Betacie\MangoPay\Model\Factory;

use Guzzle\Http\Message\Response;

class ModelFactory
{

    public static function make(Response $response, $class)
    {
        $data = $response->json();

        $object = new $class;

        foreach ($data as $attribute => $value) {
            $setter = 'set' . lcfirst($attribute);

            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
            
            if ($attribute === 'ID' && method_exists($object, 'setMangoPayId')) {
                $object->setMangoPayId($value);
            }
        }

        return $object;
    }

}