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
}
