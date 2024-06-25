<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class E100Helper
{
    use Curl;

    /**
     * @throws GuzzleException
     */
    public function token()
    {
        $curl = $this->post(config('e100.api_url') . 'oauth2/token', [
            'auth'        => [
                config('e100.client_id'),
                config('e100.client_secret'),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);
        $response = json_decode($curl->getBody(), true);
        if (isset($response['access_token'])) {
            return $response['access_token'];
        } else {
            Log::info('Get token:', [$response->getBody()]);
            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function order($token, $data): ResponseInterface
    {
        return $this->post(config('e100.api_url') . 'refueling/prepaid', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ],
            'json'    => $data
        ]);
    }
}