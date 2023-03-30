<?php

namespace Potelo\InterPhp\Api;

use Potelo\InterPhp\HttpClient;

class ApiRequest
{
    /** @var string default base URL for Banco Inter's API */
    const DEFAULT_API_BASE = 'https://cdpj.partners.bancointer.com.br/';

    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param  string  $path
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getApi(string $path)
    {
        return $this->httpClient->request('GET', $path);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function postApi(string $path, array $options = [])
    {
        return $this->httpClient->request('POST', $path, $options);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function putApi(string $path, array $options = [])
    {
        return $this->httpClient->request('PUT', $path, $options);
    }

    /**
     * @param  string  $path
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function patchApi(string $path, array $options = [])
    {
        return $this->httpClient->request('PATCH', $path, $options);
    }
}
