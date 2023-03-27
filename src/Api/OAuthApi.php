<?php

namespace Potelo\InterPhp\Api;

class OAuthApi extends ApiRequest
{
    const BASE_PATH = self::DEFAULT_API_BASE . 'oauth/v2/token';

    public function getAuthorization(string $clientId, string $clientSecret, $scopes = [])
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'scope' => implode(' ', $scopes),
            ]
        ];

        $response = $this->postApi(self::BASE_PATH, $options);

        return json_decode($response->getBody()->getContents());
    }
}
