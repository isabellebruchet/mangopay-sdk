# mangopay-sdk

PHP SDK to use MangoPay API.
mangopay-sdk integrate Guzzle for all the cURL requests. We only creates a plugin names [LeetchiPlugin](https://github.com/betacie/mangopay-sdk/blob/master/LeetchiPlugin.php) which will sign all your requests to the MangoPay API.

### Installation

The recommended way to install mangopay-sdk is through [Composer](http://getcomposer.org/)

```
composer require "betacie/mangopay-sdk": "dev-master"
composer update betacie/mangopay-sdk
```

### Configuration

To request the API, you need to instantiate a Guzzle Client and add him the dedicated plugin.

```php
<?php

use Betacie\MangoPay\LeetchiPlugin;
use Guzzle\Http\Client;

$client = new Client('https://api.leetchi.com/v1/partner/{partnerId}/', array(
    'partnerId'                 => 'your_partner_id',
    'ssl.certificate_authority' => false,
    'request.options'           => array(
        'headers' => array('Content-Type' => 'application/json'),
    )
));

$plugin = new LeetchiPlugin('private_key_path', 'private_key_passphrase');
$client->addSubscriber($plugin);
```

Now you can use the API.

### Usage

Now all you need, is to create a message. For exemple if you need to create an user you only have to write the following code.

```php
<?php

use Betacie\MangoPay\Message\UserRequest;

//You already have created your client with the plugin.

$message = new UserRequest($client);
$response = $message->create(array(
    'Email' => 'j.doe@email.tld',
    'FirstName' => 'John',
    'LastName' => 'Doe',
    'IP' => '127.0.0.1',
    ...
));

$data = $response->json();
```
All message methods return a [GuzzleResponse](https://github.com/guzzle/guzzle/blob/master/src/Guzzle/Http/Message/Response.php).
