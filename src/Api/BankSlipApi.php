<?php

namespace Potelo\InterPhp\Api;

use Datetime;
use Potelo\InterPhp\Models\Payer;

class BankSlipApi extends ApiRequest
{
    const BASE_PATH = self::DEFAULT_API_BASE . 'cobranca/v2/boletos/';

    /**
     * Endpoint to create a Bank Slip.
     * @see https://developers.bancointer.com.br/reference/incluirboleto-1
     *
     * @param  string  $yourNumber
     * @param  float  $amount
     * @param  \Datetime  $dueDate
     * @param  int  $daysToExpire
     * @param  \Potelo\InterPhp\Models\Payer  $payer
     * @param  array  $data
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $yourNumber, float $amount, Datetime $dueDate, int $daysToExpire, Payer $payer, array $data = [])
    {
        $options = [
            'json' => array_merge($data, [
                'seuNumero' => $yourNumber,
                'valorNominal' => $amount,
                'dataVencimento' => $dueDate->format('Y-m-d'),
                'numDiasAgenda' => $daysToExpire,
                'pagador' => $payer->getPayload(),
            ]),
        ];

        $response = $this->postApi(self::BASE_PATH, $options);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to get a Bank Slip.
     * @see https://developers.bancointer.com.br/reference/consultarboleto
     *
     * @param  string  $ourNumber
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $ourNumber)
    {
        $response = $this->getApi(self::BASE_PATH . $ourNumber);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to get a Bank Slip PDF.
     * @see https://developers.bancointer.com.br/reference/descarregarpdfboleto
     *
     * @param  string  $ourNumber
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPdf(string $ourNumber)
    {
        $response = $this->getApi(self::BASE_PATH . $ourNumber . '/pdf');

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to get a list of Bank Slips.
     * @see https://developers.bancointer.com.br/reference/pesquisarboletos-1
     *
     * @param  \Datetime  $after
     * @param  \Datetime  $before
     * @param  array  $filters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(DateTime $after, DateTime $before, array $filters = [])
    {
        $filters = array_merge($filters, [
            'dataInicial' => $after->format('Y-m-d'),
            'dataFinal' => $before->format('Y-m-d'),
        ]);

        $response = $this->getApi(self::BASE_PATH . '?' . http_build_query($filters));

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to get a summary of Bank Slips.
     * @see https://developers.bancointer.com.br/reference/consultarsumario-1
     *
     * @param  \Datetime  $after
     * @param  \Datetime  $before
     * @param  array  $filters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function summary(DateTime $after, DateTime $before, array $filters = [])
    {
        $filters = array_merge($filters, [
            'dataInicial' => $after->format('Y-m-d'),
            'dataFinal' => $before->format('Y-m-d'),
        ]);

        $response = $this->getApi(self::BASE_PATH . 'sumario?' . http_build_query($filters));

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to cancel a Bank Slip.
     * @see https://developers.bancointer.com.br/reference/baixarboleto
     *
     * @param  string  $ourNumber
     * @param  string  $cancelReason
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function cancel(string $ourNumber, string $cancelReason)
    {
        $options = [
            'json' => [
                'motivoCancelamento' => $cancelReason,
            ],
        ];

        $response = $this->postApi(self::BASE_PATH . $ourNumber . '/cancelar', $options);

        return json_decode($response->getBody()->getContents());
    }

}
