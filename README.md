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

### Getting Authorization

```php
$privateKey = 'you-private-key-path.key';
$certificate = 'you-certificate-path.crt';
$clientId = 'you-client-id';
$clientSecret = 'your-client-secret';

$client = new \Potelo\InterPhp\InterClient($privateKey, $certificate, $clientId, $clientSecret);

$scopes = ['cob.read cob.write'];
$client->authorize($scopes);
```
### `Immediate Charge` API

#### `get` [doc](https://developers.bancointer.com.br/reference/get_cob-txid-1)

```php
$immediateCharge = $client->immediateChargeApi()->get('your-immediate-charge-txid');

print_r($immediateCharge);
```

#### `create` [doc](https://developers.bancointer.com.br/reference/post_cob-1)

```php
$secondsToExpiry = 3600;
$amount = 12.50;
$pixKey = 'your-pix-key';

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

$immediateCharge = $client->immediateChargeApi()->create($secondsToExpiry, $amount, $pixKey, $data);

print_r($immediateCharge);
```

#### `all` [doc](https://developers.bancointer.com.br/reference/get_cob-1)

```php
$after = new \DateTime('2023-03-01T00:00:00-03:00');
$before = new \DateTime('2023-03-23T23:59:00-03:00');

$immediateCharges = $client->immediateChargeApi()->all($after, $before);

print_r($immediateCharges);
```

Other filters

```php
$after = new \DateTime('2023-03-01T00:00:00-03:00');
$before = new \DateTime('2023-03-23T23:59:00-03:00');
$filters = [
    'cpf' => '00000000000',
];

$immediateCharges = $client->immediateChargeApi()->all($after, $before, $filters);

print_r($immediateCharges);
```
## API Documentation

The Banco Inter API documentation can be found [here](https://developers.bancointer.com.br/).
