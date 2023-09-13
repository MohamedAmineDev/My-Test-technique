<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Order;
use App\Entity\SalesOrderLine;
use App\Repository\ArticleRepository;
use App\Repository\ContactRepository;
use App\Repository\OrderRepository;
use App\Repository\SalesOrderLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SaveDataService
{
    private $articelRepo;
    private $contactRepo;
    private $orderRepo;
    private $salesOrderLineRepo;
    private $entityManager;
    public function __construct(ArticleRepository $articelRepo, ContactRepository $contactRepo, OrderRepository $orderRepo, SalesOrderLineRepository $salesOrderLineRepo, EntityManagerInterface $entityManager)
    {
        $this->articelRepo = $articelRepo;
        $this->contactRepo = $contactRepo;
        $this->orderRepo = $orderRepo;
        $this->salesOrderLineRepo = $salesOrderLineRepo;
        $this->entityManager = $entityManager;
    }
    // This method will save the contacts that were loaded from the api
    public function saveContacts($contacts): bool
    {
        try {
            $content = $contacts["results"];
            $i = 0;
            $saved = false;
            while ($i < count($content)) {
                $id = $content[$i]["ID"];
                $contact = $this->contactRepo->findById($id);
                if ($contact == null) {
                    $newContact = new Contact();
                    $newContact->setId($id);
                    $newContact->setAccountName($content[$i]["AccountName"]);
                    $newContact->setAddressLine1($content[$i]["AddressLine1"]);
                    $newContact->setAddressLine2($content[$i]["AddressLine2"]);
                    $newContact->setCity($content[$i]["City"]);
                    $newContact->setContactName($content[$i]["ContactName"]);
                    $newContact->setCountry($content[$i]["Country"]);
                    $newContact->setZipCode($content[$i]["ZipCode"]);
                    $this->entityManager->persist($newContact);
                    $saved = true;
                }
                $i++;
            }
            if ($saved) {
                $this->entityManager->flush();
            }
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
    public function saveOrders($orders): bool
    {
        try {
            $content = $orders["results"];
            $i = 0;
            while ($i < count($content)) {
                $orderId = $content[$i]["OrderID"];
                $order = $this->orderRepo->findById($orderId);
                if ($order == null) {
                    $order = new Order();
                    $delivredTo = $this->contactRepo->findById($content[$i]["DeliverTo"]);
                    $order->setAmount($content[$i]["Amount"]);
                    $order->setDeliverTo($delivredTo);
                    $order->setCurrency($content[$i]["Currency"]);
                    $order->setId($content[$i]["OrderID"]);
                    $order->setOrderNumber($content[$i]["OrderNumber"]);
                    $this->entityManager->persist($order);
                    $this->entityManager->flush();
                    $salesOrderLines = $content[$i]["SalesOrderLines"]["results"];
                    $j = 0;
                    while ($j < count($salesOrderLines)) {
                        $newSalesOrderLine = new SalesOrderLine();
                        $articleId = $salesOrderLines[$j]["Item"];
                        $article = $this->articelRepo->findById($articleId);
                        //dd($article);
                        if ($article == null) {
                            $article = new Article();
                            $article->setId($articleId);
                            $article->setUnitCode($salesOrderLines[$j]["UnitCode"]);
                            $article->setArticleDescription($salesOrderLines[$j]["ItemDescription"]);
                            $article->setUnitDescription($salesOrderLines[$j]["UnitDescription"]);
                            $article->setVatAmount($salesOrderLines[$j]["VATAmount"]);
                            $article->setUnitPrice($salesOrderLines[$j]["UnitPrice"]);
                            $article->setVatPercentage($salesOrderLines[$j]["VATPercentage"]);
                            $newSalesOrderLine->setArticle($article);
                        }
                        $newSalesOrderLine->setAmount($salesOrderLines[$j]["Amount"]);
                        $newSalesOrderLine->setDiscount($salesOrderLines[$j]["Discount"]);
                        $newSalesOrderLine->setQuantity($salesOrderLines[$j]["Quantity"]);
                        $newSalesOrderLine->setTheOrder($order);
                        $newSalesOrderLine->setArticle($article);
                        $article->addSalesOrderLine($newSalesOrderLine);
                        $this->entityManager->persist($article);
                        //$this->entityManager->persist($newSalesOrderLine);
                        $this->entityManager->flush();
                        //dd($newSalesOrderLine);
                        $j++;
                    }
                }
                $i++;
            }
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}
