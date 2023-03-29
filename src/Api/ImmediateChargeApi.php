<?php

namespace Potelo\InterPhp\Api;

class ImmediateChargeApi extends ApiRequest
{
    const BASE_PATH = self::DEFAULT_API_BASE . 'pix/v2/cob/';

    /**
     * @param  string  $txId
     * @return mixed
     */
    public function get(string $txId)
    {
        $response = $this->getApi(self::BASE_PATH . $txId);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param  \DateTime  $after
     * @param  \DateTime  $before
     * @param  array  $filters
     * @return mixed
     */
    public function all(\DateTime $after, \DateTime $before, array $filters = [])
    {
        $filters = array_merge($filters, [
            'inicio' => $after->format('Y-m-d\TH:i:s\-03:00'),
            'fim' => $before->format('Y-m-d\TH:i:s\-03:00'),
        ]);

        $response = $this->getApi(self::BASE_PATH . '?' . http_build_query($filters));

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param  string  $key the pix key
     * @param  float  $amount the amount to charge
     * @param  int  $expiration the seconds to the charge expire
     * @param  array  $data the data to be sent
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
