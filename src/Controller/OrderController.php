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

use App\Form\ConsumeApiType;
use App\Repository\OrderRepository;
use App\Service\CsvFileManipulationService;
use App\Service\LoadDataService;
use App\Service\SaveDataService;
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
    #[Route('/orders', name: 'app_orders',methods:["GET"])]
    public function index(Request $request, OrderRepository $orderRepo): Response
    {
        $myForm = $this->createForm(ConsumeApiType::class,options:[
            'action' => $this->generateUrl('app_flow'),
            'method' => 'GET',
            'attr' => ['target' => '_blank']
            ]
        );
        $page = $request->query->getInt("page", 1);
        $response = $orderRepo->paginationQuery($page, 4);
        $orders = $response["data"];
        $currentPage = $response["page"];
        $pages = $response["pages"];
        $limit = $response["limit"];
        //dd($limit);
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'limit' => $limit,
            'path' => 'app_orders',
            'myForm' => $myForm->createView()
        ]);
    }
    #[Route('/flow/orders_to_csv', name: 'app_flow',methods:["GET"])]
    public function ordersToCsv(Request $request, LoadDataService $loadDataService, SaveDataService $saveDataService,CsvFileManipulationService $csvFileManipulationService): Response
    {
        $myForm = $this->createForm(ConsumeApiType::class,options:[
            'action' => $this->generateUrl('app_flow'),
            'method' => 'GET',
            'attr' => ['target' => '_blank']
            ]
        );
        $myForm->handleRequest($request);
        if ($myForm->isSubmitted() && $myForm->isValid()) {
            $data=$myForm->getData();
            $url=$data["apiUrl"];
            $key=$data["apiKey"];
            $response=$loadDataService->loadDataFromAnApi($url,$key);
            if(str_contains($url,"contact")){
                $result=$saveDataService->saveContacts($response);
            }
            else{
                if(str_contains($url,"order")){
                    $result=$saveDataService->saveOrders($response);
                }
            }
            $csvFileManipulationService->fetchOrders("orders.csv");
            
        }
        return $this->render('empty/empty.html.twig', [
              
        ]);
    }
}
