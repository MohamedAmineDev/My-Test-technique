<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Tests\Integration
 * @copyright 2023 Quantic Factory
 */

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Cette classe  représente  les tests d'intégrations qui doivent être effectués sur  OrderController
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class OrderControllerTest extends WebTestCase
{
    public function testOrders(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/orders');
        $this->assertResponseIsSuccessful();
    }
}
