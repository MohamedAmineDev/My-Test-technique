<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SalesOrderLineControllerTest extends WebTestCase
{
    public function testSalesOrderLines(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/order/___/items');
        $this->assertResponseIsSuccessful();
    }
}
