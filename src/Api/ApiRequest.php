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

    protected function getApi($path)
    {
        return $this->httpClient->request('GET', $path);
    }

    protected function postApi($path, $options = [])
    {
        return $this->httpClient->request('POST', $path, $options);
    }

    protected function putApi($path, $options = [])
    {
        return $this->httpClient->request('PUT', $path, $options);
    }
}
