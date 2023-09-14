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
 * La classe  permet de gérer les requêtes vers la ressource order
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'app_orders')]
    public function index(Request $request,OrderRepository $orderRepo): Response
    {
        $page=$request->query->getInt("page",1);
        $response=$orderRepo->paginationQuery($page,4);
        $orders=$response["data"];
        $currentPage=$response["page"];
        $pages=$response["pages"];
        $limit=$response["limit"];
        //dd($limit);
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'limit' => $limit,
            'path'=>'app_orders'
        ]);
    }
}
