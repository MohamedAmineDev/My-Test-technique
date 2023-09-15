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
 * Cette classe  représente  les tests d'intégrations qui doivent être effectués sur  SalesOrderLineController
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class SalesOrderLineControllerTest extends WebTestCase
{
    public function testSalesOrderLines(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/order/___/items');
        $this->assertResponseIsSuccessful();
    }
}
