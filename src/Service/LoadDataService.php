<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class LoadDataService{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client=$client;
    }
    // Load orders from the specified api
    public function getOrders():array
    {
       return $this->getDataService("orders");
    }
    // Load contacts from the specified api
    public function getContacts():array
    {
       return $this->getDataService("contacts");
    }
    // Global api consumption
    private function getDataService(String $name):array
    {
        $response=$this->client->request("GET","https://internshipapi-pylfsebcoa-ew.a.run.app/".$name,["headers"=>["x-api-key"=>"PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b"]]);
        return $response->toArray();
    }
}
?>