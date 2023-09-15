<?php

namespace App\Tests;

use App\Entity\Contact;
use App\Entity\Order;
use App\Entity\SalesOrderLine;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\isNull;

class OrderUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $order = new Order();
        $order->setId("id")
            ->setAmount(10.5)
            ->setCurrency("$")
            ->setOrderNumber(10);
        $contact = new Contact();
        $contact->setId("id");
        $order->setDeliverTo($contact);
        $salesOrderLine = new SalesOrderLine();
        $order->addSalesOrderLine($salesOrderLine);
        //Les assertions
        $this->assertTrue($order->getId() == "id");
        $this->assertTrue($order->getAmount() == 10.5);
        $this->assertTrue($order->getCurrency() == "$");
        $this->assertTrue($order->getOrderNumber() == 10);
        $this->assertTrue($order->getDeliverTo()!=null);
        $this->assertTrue($order->getSalesOrderLines()->contains($salesOrderLine));
        $order->removeSalesOrderLine($salesOrderLine);
        $this->assertTrue($order->getSalesOrderLines()->contains($salesOrderLine) == false);
    }

    public function testIsFalse(): void
    {
        $order = new Order();
        $order->setId("id")
            ->setAmount(10.5)
            ->setCurrency("$")
            ->setOrderNumber(10);
        $contact = new Contact();
        $contact->setId("id");
        $order->setDeliverTo($contact);
        $salesOrderLine = new SalesOrderLine();
        $order->addSalesOrderLine($salesOrderLine);
        //Les assertions
        $this->assertFalse($order->getId() != "id");
        $this->assertFalse($order->getAmount() != 10.5);
        $this->assertFalse($order->getCurrency() != "$");
        $this->assertFalse($order->getOrderNumber() != 10);
        $this->assertFalse($order->getDeliverTo() == null);
        $this->assertFalse($order->getSalesOrderLines()->contains($salesOrderLine) == false);
        $order->removeSalesOrderLine($salesOrderLine);
        $this->assertFalse($order->getSalesOrderLines()->contains($salesOrderLine) == true);
    }

    public function testIsEmpty(): void
    {
        $order = new Order();
        //Les assertions
        $this->assertEmpty($order->getId());
        $this->assertEmpty($order->getAmount());
        $this->assertEmpty($order->getCurrency());
        $this->assertEmpty($order->getOrderNumber());
        $this->assertEmpty($order->getDeliverTo());
        $this->assertEmpty($order->getSalesOrderLines());
    }
}
