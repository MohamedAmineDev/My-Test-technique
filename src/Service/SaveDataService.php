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
            //Récupération du contenu de la réponse de l'api
            $contacts = $result["results"];
            //On parcourt la liste de contact
            foreach ($contacts as $currentContact) {
                $id = $currentContact["ID"];
                //On cherche si on a déjà ce contact dans la base de données
                $contact = $this->contactRepo->findById($id);
                //Dans le cas où on n'a pas ce contact on l'ajoute
                if ($contact == null) {
                    $newContact = new Contact();
                    $newContact->setId($id)
                        ->setAccountName($currentContact["AccountName"])
                        ->setAddressLine1($currentContact["AddressLine1"])
                        ->setAddressLine2($currentContact["AddressLine2"])
                        ->setCity($currentContact["City"])
                        ->setContactName($currentContact["ContactName"])
                        ->setCountry($currentContact["Country"])
                        ->setZipCode($currentContact["ZipCode"]);
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
            //Récupération du contenu de la réponse de l'api
            $orders = $result["results"];
            //On parcourt la liste de commande
            foreach ($orders as $currentOrder) {
                $orderId = $currentOrder["OrderID"];
                //On cherche si on a déjà cette commande dans la base de données
                $order = $this->orderRepo->findById($orderId);
                //Dans le cas où on n'a pas cette commande on l'ajoute
                if ($order == null) {
                    $order = new Order();
                    //On récupère le contact par son id
                    $delivredTo = $this->contactRepo->findById($currentOrder["DeliverTo"]);
                    $order->setAmount($currentOrder["Amount"])
                        ->setDeliverTo($delivredTo)
                        ->setCurrency($currentOrder["Currency"])
                        ->setId($currentOrder["OrderID"])
                        ->setOrderNumber($currentOrder["OrderNumber"]);
                    $this->entityManager->persist($order);
                    $this->entityManager->flush();
                    //On récupère les lignes de commande
                    $salesOrderLines = $currentOrder["SalesOrderLines"]["results"];
                    foreach ($salesOrderLines as $currentSalesOrderLine) {
                        $newSalesOrderLine = new SalesOrderLine();
                        $articleId = $currentSalesOrderLine["Item"];
                        //On cherche si on a déjà cet article dans la base de données
                        $article = $this->articelRepo->findById($articleId);
                        $new = false;
                        //Dans le cas où on n'a pas cette commande on l'ajoute
                        if ($article == null) {
                            $article = new Article();
                            $article->setId($articleId)
                                ->setUnitCode($currentSalesOrderLine["UnitCode"])
                                ->setArticleDescription($currentSalesOrderLine["ItemDescription"])
                                ->setUnitDescription($currentSalesOrderLine["UnitDescription"])
                                ->setVatAmount($currentSalesOrderLine["VATAmount"])
                                ->setUnitPrice($currentSalesOrderLine["UnitPrice"])
                                ->setVatPercentage($currentSalesOrderLine["VATPercentage"]);
                            $newSalesOrderLine->setArticle($article);
                            $new = true;
                        }
                        $newSalesOrderLine->setAmount($currentSalesOrderLine["Amount"])
                            ->setDiscount($currentSalesOrderLine["Discount"])
                            ->setQuantity($currentSalesOrderLine["Quantity"])
                            ->setTheOrder($order)
                            ->setArticle($article);
                        //On ajoute la ligne de commande a l'article
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
