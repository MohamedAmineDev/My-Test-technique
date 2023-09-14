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

class SalesOrderLineController extends AbstractController
{
    #[Route('/order/{orderId}/items', name: 'app_order_details')]
    public function index(string $orderId,OrderRepository $orderRepo,Request $request): Response
    {
        $order=$orderRepo->findById($orderId);
        $page=$request->query->getInt("page",1);
        return $this->render('sales_order_line/index.html.twig', [
            'path' => 'app_order_details',
            'sales'=>$order->getSalesOrderLines(),
            'totalAmount'=>$order->getAmount(),
            'page'=>$page
        ]);
    }
}
