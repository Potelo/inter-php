<?php

namespace Potelo\InterPhp\Models;

class Payer
{
    public string $cpfCnpj;

    public string $personType;

    public string $name;

    public string $address;

    public string $city;

    public string $state;

    public string $zipCode;

    public ?string $number = null;

    public ?string $complement = null;

    public ?string $district = null;

    public ?string $email = null;

    public ?string $areaCode = null;

    public ?string $phone = null;

    /**
     * @param  string  $cpfCnpj
     * @param  string  $personType
     * @param  string  $name
     * @param  string  $address
     * @param  string  $city
     * @param  string  $state
     * @param  string  $zipCode
     */
    public function __construct(string $cpfCnpj, string $personType, string $name, string $address, string $city, string $state, string $zipCode)
    {
        $this->cpfCnpj = $cpfCnpj;
        $this->personType = $personType;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        $payer = [
            'cpfCnpj' => $this->cpfCnpj,
            'tipoPessoa' => $this->personType,
            'nome' => $this->name,
            'endereco' => $this->address,
            'cidade' => $this->city,
            'uf' => $this->state,
            'cep' => $this->zipCode,
        ];

        if ($this->number) {
            $payer['numero'] = $this->number;
        }

        if ($this->complement) {
            $payer['complemento'] = $this->complement;
        }

        if ($this->district) {
            $payer['bairro'] = $this->district;
        }

        if ($this->email) {
            $payer['email'] = $this->email;
        }

        if ($this->areaCode) {
            $payer['ddd'] = $this->areaCode;
        }

        if ($this->phone) {
            $payer['telefone'] = $this->phone;
        }

        return $payer;
    }
}
