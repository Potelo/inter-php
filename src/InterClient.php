<?php

namespace Potelo\InterPhp;

class InterClient
{
    private HttpClient $httpClient;

    private string $privateKey;

    private string $certificate;

    private string $clientId;

    private string $clientSecret;

    public function __construct(string $privateKey, string $certificate, string $clientId, string $clientSecret)
    {
        $this->privateKey = $privateKey;
        $this->certificate = $certificate;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function authorize(array $scopes)
    {
        $authorization = (new Api\OAuthApi(new HttpClient($this->privateKey, $this->certificate)))
            ->getAuthorization($this->clientId, $this->clientSecret, $scopes);

        $this->httpClient = new HttpClient($this->privateKey, $this->certificate, $authorization->access_token);
    }

    public function immediateChargeApi()
    {
        return new Api\ImmediateChargeApi($this->httpClient);
    }
}
