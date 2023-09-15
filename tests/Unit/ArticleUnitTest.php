<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\SalesOrderLine;
use PHPUnit\Framework\TestCase;

class ArticleUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $article = new Article();
        $article->setId("id")
            ->setArticleDescription("Description")
            ->setUnitDescription("unit")
            ->setUnitCode("AR")
            ->setUnitPrice(10.5)
            ->setVatAmount(25.50)
            ->setVatPercentage(0.2);
        $salesOrderLine = new SalesOrderLine();
        $salesOrderLine->setArticle($article);
        $article->addSalesOrderLine($salesOrderLine);
        // Les assertions
        $this->assertTrue($article->getId() != "");
        $this->assertTrue($article->getArticleDescription() != "");
        $this->assertTrue($article->getUnitDescription() != "");
        $this->assertTrue($article->getUnitCode() != "");
        $this->assertTrue($article->getUnitPrice() == 10.5);
        $this->assertTrue($article->getVatAmount() == 25.50);
        $this->assertTrue($article->getVatPercentage() == 0.2);
        $this->assertTrue($article->getSalesOrderLines()->contains($salesOrderLine));
        $article->removeSalesOrderLine($salesOrderLine);
        $this->assertTrue(!$article->getSalesOrderLines()->contains($salesOrderLine));
    }


    public function testIsFalse(): void
    {
        $article = new Article();
        $article->setId("id")
            ->setArticleDescription("Description")
            ->setUnitDescription("unit")
            ->setUnitCode("AR")
            ->setUnitPrice(10.5)
            ->setVatAmount(25.50)
            ->setVatPercentage(0.2);
        $salesOrderLine = new SalesOrderLine();
        $salesOrderLine->setArticle($article);
        $article->addSalesOrderLine($salesOrderLine);
        // Les assertions
        $this->assertFalse($article->getId() == "");
        $this->assertFalse($article->getArticleDescription() == "");
        $this->assertFalse($article->getUnitDescription() == "");
        $this->assertFalse($article->getUnitCode() == "");
        $this->assertFalse($article->getUnitPrice() != 10.5);
        $this->assertFalse($article->getVatAmount() != 25.50);
        $this->assertFalse($article->getVatPercentage() != 0.2);
        $this->assertFalse($article->getSalesOrderLines()->contains($salesOrderLine) == false);
        $article->removeSalesOrderLine($salesOrderLine);
        $this->assertFalse($article->getSalesOrderLines()->contains($salesOrderLine) == true);
    }


    public function testIsEmpty(): void
    {
        $article = new Article();
        // Les assertions
        $this->assertEmpty($article->getId());
        $this->assertEmpty($article->getArticleDescription());
        $this->assertEmpty($article->getUnitDescription());
        $this->assertEmpty($article->getUnitCode());
        $this->assertEmpty($article->getUnitCode());
        $this->assertEmpty($article->getVatAmount());
        $this->assertEmpty($article->getVatPercentage());
        $this->assertEmpty($article->getSalesOrderLines());
    }
}
