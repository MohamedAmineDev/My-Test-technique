<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Service
 * @copyright 2023 Quantic Factory
 */

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * La classe LoadDataService permet de gérer la récuperation des données depuis un api externe
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class LoadDataService
{

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Elle consomme un api externe
     *
     * @param string $url
     * 
     * @param string $key
     * 
     * @return array
     *
     *
     */

    public function loadDataFromAnApi(string $url, string $key): array
    {
        $response = $this->client->request("GET", "$url", ["headers" => ["x-api-key" => "$key"]]);
        return $response->toArray();
    }
}
