<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait Curl
{
    /**
     * @throws GuzzleException
     */
    public function post($url, $data)
    {
        $client = new Client();
        return $client->post($url, $data);
    }
}