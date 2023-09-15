<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Service
 * @copyright 2023 Quantic Factory
 */

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

/**
 * Cette classe  permet de sauvegarder les données récupérées dans une base de données
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class SaveDataService
{
    private ArticleRepository $articelRepo;
    private ContactRepository $contactRepo;
    private OrderRepository $orderRepo;
    private EntityManagerInterface $entityManager;

    public function __construct(ArticleRepository $articelRepo, ContactRepository $contactRepo, OrderRepository $orderRepo,  EntityManagerInterface $entityManager)
    {
        $this->articelRepo = $articelRepo;
        $this->contactRepo = $contactRepo;
        $this->orderRepo = $orderRepo;
        $this->entityManager = $entityManager;
    }

    /**
     * Sauvegarde les contacts fournis dans le paramètre
     *
     * @param array $result
     *
     *
     * @return bool
     */

    public function saveContacts(array $result): bool
    {
        try {
            $contacts = $result["results"];
            foreach ($contacts as $currentContact) {
                $id = $currentContact["ID"];
                $contact = $this->contactRepo->findById($id);
                if ($contact == null) {
                    $newContact = new Contact();
                    $newContact->setId($id);
                    $newContact->setAccountName($currentContact["AccountName"]);
                    $newContact->setAddressLine1($currentContact["AddressLine1"]);
                    $newContact->setAddressLine2($currentContact["AddressLine2"]);
                    $newContact->setCity($currentContact["City"]);
                    $newContact->setContactName($currentContact["ContactName"]);
                    $newContact->setCountry($currentContact["Country"]);
                    $newContact->setZipCode($currentContact["ZipCode"]);
                    $this->entityManager->persist($newContact);
                    $this->entityManager->flush();
                }
            }
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }

    /**
     * Sauvegarde les commandes fournis dans le paramètre
     *
     * @param array $result
     *
     *
     * @return bool
     */

    public function saveOrders($result): bool
    {
        try {
            $orders = $result["results"];
            foreach ($orders as $currentOrder) {
                $orderId = $currentOrder["OrderID"];
                $order = $this->orderRepo->findById($orderId);
                if ($order == null) {
                    $order = new Order();
                    $delivredTo = $this->contactRepo->findById($currentOrder["DeliverTo"]);
                    $order->setAmount($currentOrder["Amount"]);
                    $order->setDeliverTo($delivredTo);
                    $order->setCurrency($currentOrder["Currency"]);
                    $order->setId($currentOrder["OrderID"]);
                    $order->setOrderNumber($currentOrder["OrderNumber"]);
                    $this->entityManager->persist($order);
                    $this->entityManager->flush();
                    $salesOrderLines = $currentOrder["SalesOrderLines"]["results"];
                    foreach ($salesOrderLines as $currentSalesOrderLine) {
                        $newSalesOrderLine = new SalesOrderLine();
                        $articleId = $currentSalesOrderLine["Item"];
                        $article = $this->articelRepo->findById($articleId);
                        $new = false;
                        if ($article == null) {
                            $article = new Article();
                            $article->setId($articleId);
                            $article->setUnitCode($currentSalesOrderLine["UnitCode"]);
                            $article->setArticleDescription($currentSalesOrderLine["ItemDescription"]);
                            $article->setUnitDescription($currentSalesOrderLine["UnitDescription"]);
                            $article->setVatAmount($currentSalesOrderLine["VATAmount"]);
                            $article->setUnitPrice($currentSalesOrderLine["UnitPrice"]);
                            $article->setVatPercentage($currentSalesOrderLine["VATPercentage"]);
                            $newSalesOrderLine->setArticle($article);
                            $new = true;
                        }
                        $newSalesOrderLine->setAmount($currentSalesOrderLine["Amount"]);
                        $newSalesOrderLine->setDiscount($currentSalesOrderLine["Discount"]);
                        $newSalesOrderLine->setQuantity($currentSalesOrderLine["Quantity"]);
                        $newSalesOrderLine->setTheOrder($order);
                        $newSalesOrderLine->setArticle($article);
                        $article->addSalesOrderLine($newSalesOrderLine);
                        if ($new) {
                            $this->entityManager->persist($article);
                        }
                        $this->entityManager->flush();
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
}
