<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Tests\Unit
 * @copyright 2023 Quantic Factory
 */

namespace App\Tests;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\SalesOrderLine;
use PHPUnit\Framework\TestCase;

/**
 * Cette classe  représente  les tests unitaires qui doivent être effectués sur  l'entité SalesOrderLine
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class SalesOrderLineUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $salesOrderLine = new SalesOrderLine();
        $salesOrderLine->setId(10)
            ->setAmount(10.50)
            ->setDiscount(0.5)
            ->setQuantity(20);
        $order = new Order();
        $order->setId("id");
        $article = new Article();
        $article->setId("id");
        $salesOrderLine->setTheOrder($order);
        $salesOrderLine->setArticle($article);
        //Les assertions
        $this->assertTrue($salesOrderLine->getId() == 10);
        $this->assertTrue($salesOrderLine->getAmount() == 10.50);
        $this->assertTrue($salesOrderLine->getDiscount() == 0.5);
        $this->assertTrue($salesOrderLine->getQuantity() == 20);
        $this->assertTrue($salesOrderLine->getTheOrder() != null);
        $this->assertTrue($salesOrderLine->getArticle() != null);
    }

    public function testIsFalse(): void
    {
        $salesOrderLine = new SalesOrderLine();
        $salesOrderLine->setId(10)
            ->setAmount(10.50)
            ->setDiscount(0.5)
            ->setQuantity(20);
        $order = new Order();
        $order->setId("id");
        $article = new Article();
        $article->setId("id");
        $salesOrderLine->setTheOrder($order);
        $salesOrderLine->setArticle($article);
        //Les assertions
        $this->assertFalse($salesOrderLine->getId() != 10);
        $this->assertFalse($salesOrderLine->getAmount() != 10.50);
        $this->assertFalse($salesOrderLine->getDiscount() != 0.5);
        $this->assertFalse($salesOrderLine->getQuantity() != 20);
        $this->assertFalse($salesOrderLine->getTheOrder() == null);
        $this->assertFalse($salesOrderLine->getArticle() == null);
    }

    public function testIsEmpty(): void
    {
        $salesOrderLine = new SalesOrderLine();
        //Les assertions
        $this->assertEmpty($salesOrderLine->getId());
        $this->assertEmpty($salesOrderLine->getAmount());
        $this->assertEmpty($salesOrderLine->getDiscount());
        $this->assertEmpty($salesOrderLine->getQuantity());
        $this->assertEmpty($salesOrderLine->getTheOrder());
        $this->assertEmpty($salesOrderLine->getArticle());
    }
}
