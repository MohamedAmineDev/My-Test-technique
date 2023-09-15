<?php
namespace App\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoadDataServiceTest  extends WebTestCase{
   
    
    public function testgetContactsIsWorking(){
        $client=static::createClient();
        $client->request("GET","/");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
?>