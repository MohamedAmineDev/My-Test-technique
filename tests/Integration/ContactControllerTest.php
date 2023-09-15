<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testContatcs(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contacts');
        $this->assertResponseIsSuccessful();
    }
}
