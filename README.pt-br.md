# Cliente PHP para API do Banco Inter

O cliente PHP para API do Banco Inter fornece acesso fácil à API do Banco Inter por
aplicações escritas na linguagem PHP.

### Outros idiomas
[![en](https://img.shields.io/badge/lang-en-red.svg)](https://github.com/Potelo/inter-php/blob/main/README.md)
[![pt-br](https://img.shields.io/badge/lang-pt--br-green.svg)](https://github.com/Potelo/inter-php/blob/main/README.pt-br.md)

## Requisitos

PHP 7.4.0 ou superior.

## Composer

Você pode instalar o pacote via [Composer](http://getcomposer.org/). Execute o seguinte comando:

```bash
composer require potelo/inter-php
```

Ou simplesmente adicione-o às dependências do seu composer.json e execute `composer update`:

```bash
"require": {
    "potelo/inter-php": "dev-main"
}
```

Para usar o cliente, use o [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading) do Composer:

```php
require_once 'vendor/autoload.php';
```
## Dependências

A biblioteca requer as seguintes extensões para funcionar corretamente:

-   [`Guzzle`](https://github.com/guzzle/guzzle)
-   [`json`](https://secure.php.net/manual/en/book.json.php)

Se você usar o Composer, essas dependências devem ser resolvidas automaticamente. Se você instalar manualmente,
certifique-se de que essas extensões estejam disponíveis.

## Usage

* [Autenticação](#getting-authorization)
* [Boleto](#bank-slip)
* [Cobrança Imediata](#immediate-charge)
* [Pix](#pix)

### <a name="getting-authorization"></a>Autenticação [doc](https://developers.bancointer.com.br/reference/token-1)

```php
$chavePrivada = 'sua-chave-privada.key';
$certificado = 'seu-certificado.crt';
$clientId = 'seu-client-id';
$clientSecret = 'seu-client-secret';

$client = new \Potelo\InterPhp\InterClient($chavePrivada, $certificado, $clientId, $clientSecret);

$escopos = ['cob.read'];
$client->authorize($escopos);
```

Você pode obter um novo token com novos escopos usando a mesma instância do cliente:

```php
$escopos = ['cob.read', 'cob.write', 'pix.read', 'pix.write'];
$client->authorize($escopos);
```

### <a name="bank-slip"></a>`Boleto` Api Cobrança

#### `get` [doc](https://developers.bancointer.com.br/reference/consultarboleto)

Consultar um boleto.

```php
$boleto = $client->bankSlipApi()->get('nosso-numero-do-boleto');

print_r($boleto);
```

#### `getPdf` [doc](https://developers.bancointer.com.br/reference/descarregarpdfboleto)

Consultar PDF de um boleto.

```php
$boleto = $client->bankSlipApi()->getPdf('nosso-numero-do-boleto');

print_r($boleto);
```

#### `create` [doc](https://developers.bancointer.com.br/reference/incluirboleto-1)

Emitir um boleto.

```php
$seuNumero = "seu-numero";
$dataVencimento = new \DateTime('2023-03-31');
$pagador = new Payer("cpf number", "FISICA", "Payer Name", "Address", "Salvador", "BA", "41000000");
$boleto = $this->client->bankSlipApi()->create($seuNumero, 10.90, $dataVencimento, 0, $pagador);

print_r($pagador);
```

#### `list` [doc](https://developers.bancointer.com.br/reference/pesquisarboletos-1)

Consultar uma lista de boletos por um período específico.

```php
$inicio = new \DateTime('2023-03-31');
$fim = new \DateTime('2023-03-31');
$boleto = $this->client->bankSlipApi()->list($inicio, $fim);

print_r($boleto);
```

#### Outros filtros

Você pode passar um array de filtros para o método `list`.

```php
$inicio = new \DateTime('2023-03-31');
$fim = new \DateTime('2023-03-31');
$filtros = [
    'filtrarDataPor' => 'VENCIMENTO',
];

$boletos = $this->client->bankSlipApi()->list($inicio, $fim, $filtros);

print_r($boletos);
```

#### `summary` [doc](https://developers.bancointer.com.br/reference/consultarsumario-1)

Consultar um sumário de uma lista de boletos.

```php
$inicio = new \DateTime('2023-03-31');
$fim = new \DateTime('2023-03-31');
$sumario = $this->client->bankSlipApi()->summary($inicio, $fim);

print_r($sumario);
```

#### `cancel` [doc](https://developers.bancointer.com.br/reference/baixarboleto)

Cancelar um boleto.

```php
$motivoCancelamento = "APEDIDODOCLIENTE";
$this->client->bankSlipApi()->cancel('nosso-numero-do-boleto', $motivoCancelamento);
```

### <a name="immediate-charge"></a>`Cobrança Imediata` API Pix

#### `get` [doc](https://developers.bancointer.com.br/reference/get_cob-txid-1)

Consultar uma Cobrança Imediata por id de transação.

```php
$cobrancaImediata = $client->immediateChargeApi()->get('txid');

print_r($cobrancaImediata);
```

#### `create` [doc](https://developers.bancointer.com.br/reference/post_cob-1)

Criar uma Cobrança Imediata.

```php
$valor = 12.50;
$chavePix = 'sua-chave-pix';
$expiracao = 3600; // em segundos

$dados = [
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

$cobrancaImediata = $client->immediateChargeApi()->create($chavePix, $valor, $expiracao, $dados);

print_r($cobrancaImediata);
```

#### `createAs` [doc](https://developers.bancointer.com.br/reference/put_cob-txid-1)

Criar uma Cobrança Imediata especificando um ID de transação único.

```php
$txId = 'seu-id-de-transacao-unico';
$valor = 12.44;
$chavePix = 'suav-chave-pix';
$expiracao = 3600; // em segundos

$dados = [
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

$cobrancaImediata = $client->immediateChargeApi()->createAs($txId, $chavePix, $valor, $expiracao, $dados);

print_r($cobrancaImediata);
```

#### `update` [doc](https://developers.bancointer.com.br/reference/patch_cob-txid-1)

Revisar uma Cobrança Imediata.

```php
$dados = [
    "valor" => 22.50
];
$cobrancaImediata = $client->immediateChargeApi()->update('cobranca-imediata-txid', $dados);

print_r($cobrancaImediata);
```

#### `list` [doc](https://developers.bancointer.com.br/reference/get_cob-1)

Consultar uma lista de Cobranças Imediatas por um período específico.

```php
$inicio = new \DateTime('2023-03-01T00:00:00-03:00');
$fim = new \DateTime('2023-03-23T23:59:00-03:00');

$cobrancasImediatas = $client->immediateChargeApi()->list($inicio, $fim);

print_r($cobrancasImediatas);
```

#### Outros filtros

Você pode passar um array de filtros para o método `list`.

```php
$inicio = new \DateTime('2023-03-01T00:00:00-03:00');
$fim = new \DateTime('2023-03-23T23:59:00-03:00');
$filtros = [
    'cpf' => '01234567891',
];

$cobrancasImediatas = $client->immediateChargeApi()->list($inicio, $fim, $filtros);

print_r($cobrancasImediatas);
```

### <a name="pix"></a>`Pix` API Pix

#### `get` [doc](https://developers.bancointer.com.br/reference/get_pix-e2eid-1)

Consultar um Pix por ID de transação.

```php
$pix = $client->pixApi()->get('pix-endToEndId');

print_r($pix);
```

#### `list` [doc](https://developers.bancointer.com.br/reference/get_pix-1)

Consultar uma lista de Pix por um período específico.

```php
$inicio = new \DateTime('2023-03-01T00:00:00-03:00');
$fim = new \DateTime('2023-03-23T23:59:00-03:00');

$listaDePix = $client->immediateChargeApi()->list($inicio, $fim);

print_r($listaDePix);
```

#### `returnPix` [doc](https://developers.bancointer.com.br/reference/put_pix-e2eid-devolucao-id-1)

Solicitar devolução de um Pix.

```php
$id = 'seu-id-unico';
$amountToReturn = 12.44;
$pix = $client->pixApi()->returnPix('pix-endToEndId', $id, $amountToReturn);

print_r($pix);
```

#### `getReturnPix` [doc](https://developers.bancointer.com.br/reference/get_pix-e2eid-devolucao-id-1)

Consultar devolução de um Pix.

```php
$id = 'your-unique-id';
$pix = $client->pixApi()->getReturnPix('pix-endToEndId', $id);

print_r($pix);
```

## Documentação da API

A documentação da API do Banco Inter pode ser encontrada [aqui](https://developers.bancointer.com.br/).
