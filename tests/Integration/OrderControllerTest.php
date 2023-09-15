<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testOrders(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders');
        $this->assertResponseIsSuccessful();
    }
}
