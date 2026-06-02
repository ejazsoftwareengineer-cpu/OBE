<?php

namespace App\Services;

use GuzzleHttp\Client;

class QuickChartService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function generateChart($chartConfig)
    {
        $response = $this->client->post('https://quickchart.io/chart/create', [
            'json' => $chartConfig
        ]);

        return json_decode($response->getBody(), true)['url'];
    }
}
