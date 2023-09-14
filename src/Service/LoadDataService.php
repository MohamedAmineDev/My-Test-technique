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

class LoadDataService{

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client=$client;
    }
   
    /*
    private function getDataService(String $name):array
    {
        $response=$this->client->request("GET","https://internshipapi-pylfsebcoa-ew.a.run.app/".$name,["headers"=>["x-api-key"=>"PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b"]]);
        return $response->toArray();
    }
    */
    /**
* Récupérer les données depuis un api externe
*
* @param string $url le url de l'api sollicité
* @param string $key la clé de l'api sollicité
*
*
* @return array Un array qui contient la réponse de l'api sollicité
*/
    public function loadDataFromAnApi(string $url,string $key):array
    {
        $response=$this->client->request("GET","$url",["headers"=>["x-api-key"=>"$key"]]);
        return $response->toArray();
    }
}
