<?php

namespace App\Http\Gateways;

use GuzzleHttp\Client;

class FlutterWavePayment implements Payment
{

    protected $client;

    public function __construct()
    {
        $this->client =  new Client([
            'base_uri' => config('app.flutterwave_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('app.flutterwave_secret_key'),
            ]
        ]);
    }

    public function initiate($data)
    {
        $response = $this->client->post('/v3/payments', [
            'json' => $data,
        ]);
        return json_decode($response->getBody());
    }

    public function tokenizedCharge($data)
    {
        $response = $this->client->post('/v3/tokenized-charges', [
            'json' => $data,
        ]);
        return json_decode($response->getBody());
    }

    public function verify($data)
    {
        $data = (object) $data;
        $tx_ref  = $data->tx_ref;
        $response = $this->client->get("/v3/transactions/verify_by_reference?tx_ref=$tx_ref");
        $decodedResponse = json_decode($response->getBody());

        return $decodedResponse;
    }

    public function verifyCard($id)
    {
        $response = $this->client->get("/v3/transactions/$id/verify");

        $decodedResponse = json_decode($response->getBody());

        if ($decodedResponse->status == 'success') {
            return $decodedResponse;
        }

        return false;
    }

    public function webhookHandler()
    {
        $data = request()->all();
    }
}
