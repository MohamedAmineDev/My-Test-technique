<?php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testArticles(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/articles');
        $this->assertResponseIsSuccessful();
    }
}
