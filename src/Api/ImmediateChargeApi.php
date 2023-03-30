<?php

namespace Potelo\InterPhp\Api;

use Datetime;

class ImmediateChargeApi extends ApiRequest
{
    const BASE_PATH = self::DEFAULT_API_BASE . 'pix/v2/cob/';

    /**
     * Endpoint to get an Immediate Charge.
     * @see https://developers.bancointer.com.br/reference/get_cob-txid-1
     *
     * @param  string  $txId
     * @return mixed
     */
    public function get(string $txId)
    {
        $response = $this->getApi(self::BASE_PATH . $txId);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Endpoint to get a list of Immediate Charges for a specific period, according to the parameters informed.
     * @see https://developers.bancointer.com.br/reference/get_cob-1
     *
     * @param  \DateTime  $after
     * @param  \DateTime  $before
     * @param  array  $filters
     * @return mixed
     */
    public function list(DateTime $after, DateTime $before, array $filters = [])
    {
        $filters = array_merge($filters, [
            'inicio' => $after->format('Y-m-d\TH:i:s\-03:00'),
            'fim' => $before->format('Y-m-d\TH:i:s\-03:00'),
        ]);

        $response = $this->getApi(self::BASE_PATH . '?' . http_build_query($filters));

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Create an Immediate Charge.
     * @see https://developers.bancointer.com.br/reference/post_cob-1
     *
     * @param  string  $key the pix key
     * @param  float  $amount the amount to charge
     * @param  int  $expiration the seconds to the charge expire
     * @param  array  $data the others data to be sent
     * @return mixed
     */
    public function create(string $key, float $amount, int $expiration, array $data = [])
    {
        $options = [
            'json' => array_merge($data, [
                'calendario' => [
                    'expiracao' => number_format($expiration),
                ],
                'valor' => [
                    'original' => number_format($amount, 2, '.', ''),
                ],
                'chave' => $key,
            ]),
        ];

        $response = $this->postApi(self::BASE_PATH, $options);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * Create an Immediate Charge with a transaction id.
     * @see https://developers.bancointer.com.br/reference/put_cob-txid-1
     *
     * @param  string  $txId
     * @param  string  $key
     * @param  float  $amount
     * @param  int  $expiration
     * @param  array  $data
     * @return mixed
     */
    public function createAs(string $txId, string $key, float $amount, int $expiration, array $data = [])
    {
        $options = [
            'json' => array_merge($data, [
                'calendario' => [
                    'expiracao' => number_format($expiration),
                ],
                'valor' => [
                    'original' => number_format($amount, 2, '.', ''),
                ],
                'chave' => $key,
            ]),
        ];

        print_r(json_encode($options));

        $response = $this->putApi(self::BASE_PATH . $txId, $options);

        return json_decode($response->getBody()->getContents());
    }
}
