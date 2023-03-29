<?php

namespace Potelo\InterPhp;

use GuzzleHttp\Client as Guzzle;

class HttpClient
{
    /**
     * User-agent to be sent with API calls
     * @var string
     */
    const USER_AGENT = 'Potelo-InterPhp/0.1';

    private Guzzle $guzzle;

    public function __construct(string $privateKey, string $certificate, string $accessToken = null)
    {
        $config = [
            'cert' => $certificate,
            'ssl_key' => $privateKey,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => self::USER_AGENT,
            ],
        ];

        if ($accessToken) {
            $config['headers']['Authorization'] = 'Bearer ' . $accessToken;
        }

        $this->guzzle = new Guzzle($config);
    }

    /**
     * @param string  $method
     * @param  string  $uri
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $uri, array $options = [])
    {
        return $this->guzzle->request($method, $uri, $options);
    }
}
