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
}
