<?php

/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Controller
 * @copyright 2023 Quantic Factory
 */

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cette classe  permet de répondre les requêtes demandant la ressource SalesOrderLine
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class SalesOrderLineController extends AbstractController
{

    /**
     * Elle retourne la  page order_details contant la liste des lignes de commande  chargées de la base de données
     *
     * @param string $orderId
     * 
     * @param OrderRepository $orderRepo 
     * 
     * @param Request $request
     * 
     * @return Response 
     *
     *
     */

    #[Route('/order/{orderId}/items', name: 'app_order_details')]
    public function index(string $orderId, OrderRepository $orderRepo, Request $request): Response
    {
        $order = $orderRepo->findById($orderId);
        $salesOrderLines = [];
        $amount = 0;
        $page = $request->query->getInt("page", 1);
        if (!is_null($order)) {
            $salesOrderLines = $order->getSalesOrderLines();
            $amount = $order->getAmount();
        }
        return $this->render('sales_order_line/index.html.twig', [
            'path' => 'app_order_details',
            'sales' => $salesOrderLines,
            'totalAmount' => $amount,
            'page' => $page
        ]);
    }
}
