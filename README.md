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

The bindings require the following extensions in order to work properly:

-   [`Guzzle`](https://github.com/guzzle/guzzle)
-   [`json`](https://secure.php.net/manual/en/book.json.php)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Usage
Simple usage looks like:

```php
$privateKey = 'you-private-key-path.key';
$certificate = 'you-certificate-path.crt';
$clientId = 'you-client-id';
$clientSecret = 'your-client-secret';
$scopes = ['cob.read'];

$client = new \Potelo\InterPhp\InterClient($privateKey, $certificate, $clientId, $clientSecret);
$client->authorize($scopes);

$immediateCharge = $client->immediateChargeApi()->get('your-immediate-charge-txid');

print_r($immediateCharge);
```

## API Documentation

The Banco Inter API documentation can be found [here](https://developers.bancointer.com.br/).
