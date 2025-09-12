<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;

class Coinbase
{
    public const API_URL = 'https://api.commerce.coinbase.com/';

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = settings('coinbase_api_key');
    }

    public function createCharge(array $data): array
    {
        $response = Http::withHeaders([
            'X-CC-Api-Key' => $this->apiKey,
            'X-CC-Version' => '2018-03-22',
            'Content-Type' => 'application/json',
        ])->post(self::API_URL . 'charges', $data);

        if ($response->failed()) {
            throw new \Exception('Error creating Coinbase charge: ' . $response->body());
        }

        return $response->json();
    }

    public function getCharge(string $chargeId): array
    {
        $response = Http::withHeaders([
            'X-CC-Api-Key' => $this->apiKey,
            'X-CC-Version' => '2018-03-22',
            'Content-Type' => 'application/json',
        ])->get(self::API_URL . 'charges/' . $chargeId);

        if ($response->failed()) {
            throw new \Exception('Error retrieving Coinbase charge: ' . $response->body());
        }

        return $response->json();
    }
}
