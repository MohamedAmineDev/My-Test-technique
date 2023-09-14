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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalesOrderLineController extends AbstractController
{
    #[Route('/sales/order/line', name: 'app_sales_order_line')]
    public function index(): Response
    {
        return $this->render('sales_order_line/index.html.twig', [
            'controller_name' => 'SalesOrderLineController',
        ]);
    }
}
