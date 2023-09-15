<?php

namespace App\Tests;

use App\Entity\Contact;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;

class ContactUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $contact = new Contact();
        $contact->setId("id")
            ->setAccountName("John Doe")
            ->setAddressLine1("address")
            ->setAddressLine2("address")
            ->setCity("city")
            ->setContactName("John Doe")
            ->setCountry("country")
            ->setZipCode("56464");
        $order = new Order();
        $order->setId("id");
        $order->setDeliverTo($contact);
        $contact->addOrder($order);
        // Les assertions
        $this->assertTrue($contact->getId() != "");
        $this->assertTrue($contact->getAccountName() != "");
        $this->assertTrue($contact->getAddressLine1() != "");
        $this->assertTrue($contact->getAddressLine2() != "");
        $this->assertTrue($contact->getCity() != "");
        $this->assertTrue($contact->getContactName() != "");
        $this->assertTrue($contact->getCountry() != "");
        $this->assertTrue($contact->getZipCode() != "");
        $this->assertTrue($contact->getOrders()->contains($order));
        $contact->removeOrder($order);
        $this->assertTrue($contact->getOrders()->contains($order) == false);
    }


    public function testIsFalse(): void
    {
        $contact = new Contact();
        $contact->setId("id")
            ->setAccountName("John Doe")
            ->setAddressLine1("address")
            ->setAddressLine2("address")
            ->setCity("city")
            ->setContactName("John Doe")
            ->setCountry("country")
            ->setZipCode("56464");
        $order = new Order();
        $order->setId("id");
        $order->setDeliverTo($contact);
        $contact->addOrder($order);
        // Les assertions
        $this->assertFalse($contact->getId() == "");
        $this->assertFalse($contact->getAccountName() == "");
        $this->assertFalse($contact->getAddressLine1() == "");
        $this->assertFalse($contact->getAddressLine2() == "");
        $this->assertFalse($contact->getCity() == "");
        $this->assertFalse($contact->getContactName() == "");
        $this->assertFalse($contact->getCountry() == "");
        $this->assertFalse($contact->getZipCode() == "");
        $this->assertFalse($contact->getOrders()->contains($order) == false);
        $contact->removeOrder($order);
        $this->assertFalse($contact->getOrders()->contains($order) == true);
    }


    public function testIsEmpty(): void
    {
        $contact = new Contact();
        // Les assertions
        $this->assertEmpty($contact->getId());
        $this->assertEmpty($contact->getAccountName());
        $this->assertEmpty($contact->getAddressLine1());
        $this->assertEmpty($contact->getAddressLine2());
        $this->assertEmpty($contact->getCity());
        $this->assertEmpty($contact->getContactName());
        $this->assertEmpty($contact->getCountry());
        $this->assertEmpty($contact->getZipCode());
        $this->assertEmpty($contact->getOrders());
    }
}
