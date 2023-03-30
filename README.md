# Banco Inter PHP client

The Banco Inter PHP client provides convenient access to the Banco Inter API from
applications written in the PHP language.

## Requirements

PHP 7.4.0 and later.

## Composer

You can install the package via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require potelo/inter-php
```

Or simply add it to your composer.json dependences and run composer update:

```bash
"require": {
    "potelo/inter-php": "dev-main"
}
```
To use the client, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```
## Dependencies

The library require the following extensions in order to work properly:

-   [`Guzzle`](https://github.com/guzzle/guzzle)
-   [`json`](https://secure.php.net/manual/en/book.json.php)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Usage

* [Getting Authorization](#getting-authorization)
* [Immediate Charge](#immediate-charge)
* [Pix](#pix)

### <a name="getting-authorization"></a>Getting Authorization [doc](https://developers.bancointer.com.br/reference/token-1)

```php
$privateKey = 'you-private-key-path.key';
$certificate = 'you-certificate-path.crt';
$clientId = 'you-client-id';
$clientSecret = 'your-client-secret';

$client = new \Potelo\InterPhp\InterClient($privateKey, $certificate, $clientId, $clientSecret);

$scopes = ['cob.read'];
$client->authorize($scopes);
```

You can get new token with new scopes using the same client instance:

```php
$scopes = ['cob.read', 'cob.write', 'pix.read', 'pix.write'];
$client->authorize($scopes);
```

### <a name="immediate-charge"></a>`Immediate Charge` Pix API

#### `get` [doc](https://developers.bancointer.com.br/reference/get_cob-txid-1)

Get an Immediate Charge by transaction id.

```php
$immediateCharge = $client->immediateChargeApi()->get('your-immediate-charge-txid');

print_r($immediateCharge);
```

#### `create` [doc](https://developers.bancointer.com.br/reference/post_cob-1)

Create a new Immediate Charge.

```php
$amount = 12.50;
$pixKey = 'your-pix-key';
$secondsToExpiry = 3600;

$data = [
    "devedor" => [
        "cpf" => "01234567891",
        "nome" => "John Doe"
    ],
    "loc" => [
        "tipoCob" => "cob"
    ],
    "solicitacaoPagador" => " ",
    "infoAdicionais" => [
        [
            "nome" => "Product",
            "valor" => "cool pajamas"
        ]
    ]
];

$immediateCharge = $client->immediateChargeApi()->create($pixKey, $amount, $secondsToExpiry, $data);

print_r($immediateCharge);
```

#### `createAs` [doc](https://developers.bancointer.com.br/reference/put_cob-txid-1)

Create a new Immediate Charge specifying a unique transaction id.

```php
$txId = 'your-unique-transaction-id';
$amount = 12.44;
$pixKey = 'your-pix-key';
$secondsToExpiry = 3600;

$data = [
    "devedor" => [
        "cpf" => "01234567891",
        "nome" => "John Doe"
    ],
    "loc" => [
        "tipoCob" => "cob"
    ],
    "solicitacaoPagador" => " ",
    "infoAdicionais" => [
        [
            "nome" => "Product",
            "valor" => "cool pajamas"
        ]
    ]
];

$immediateCharge = $client->immediateChargeApi()->createAs($txId, $pixKey, $amount, $secondsToExpiry, $data);

print_r($immediateCharge);
```

#### `list` [doc](https://developers.bancointer.com.br/reference/get_cob-1)

Get all Immediate Charges in a period.

```php
$after = new \DateTime('2023-03-01T00:00:00-03:00');
$before = new \DateTime('2023-03-23T23:59:00-03:00');

$immediateCharges = $client->immediateChargeApi()->list($after, $before);

print_r($immediateCharges);
```

#### `update` [doc](https://developers.bancointer.com.br/reference/patch_cob-txid-1)

Update an Immediate Charge.

```php
$immediateCharge = $client->immediateChargeApi()->update('your-immediate-charge-txid', [
    'valor' => 22.50
]);

print_r($immediateCharge);
```

#### Other filters

You can pass an array of filters to the `all` method.

```php
$after = new \DateTime('2023-03-01T00:00:00-03:00');
$before = new \DateTime('2023-03-23T23:59:00-03:00');
$filters = [
    'cpf' => '01234567891',
];

$immediateCharges = $client->immediateChargeApi()->list($after, $before, $filters);

print_r($immediateCharges);
```

### <a name="pix"></a>`Pix` Pix API

#### `get` [doc](https://developers.bancointer.com.br/reference/get_pix-e2eid-1)

Get a Pix by transaction id.

```php
$pix = $client->pixApi()->get('pix-endToEndId');

print_r($pix);
```

#### `list` [doc](https://developers.bancointer.com.br/reference/get_pix-1)

Get a list of Pix in a period.

```php
$after = new \DateTime('2023-03-01T00:00:00-03:00');
$before = new \DateTime('2023-03-23T23:59:00-03:00');

$pixList = $client->immediateChargeApi()->list($after, $before);

print_r($pixList);
```

#### `returnPix` [doc](https://developers.bancointer.com.br/reference/put_pix-e2eid-devolucao-id-1)

```php
$id = 'your-unique-id';
$amountToReturn = 12.44;
$pix = $client->pixApi()->returnPix('pix-endToEndId', $id, $amountToReturn);

print_r($pix);
```

#### `getReturnPix` [doc](https://developers.bancointer.com.br/reference/get_pix-e2eid-devolucao-id-1)

```php
$id = 'your-unique-id';
$pix = $client->pixApi()->getReturnPix('pix-endToEndId', $id);

print_r($pix);
```

## API Documentation

The Banco Inter API documentation can be found [here](https://developers.bancointer.com.br/).
