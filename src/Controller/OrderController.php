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
 * Cette classe  permet de répondre les requêtes demandant la ressource Order
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class OrderController extends AbstractController
{

    /**
     * Elle retourne la  page orders contant la liste des contacts paginé chargé de la base de données
     *
     * @param Request $request
     * 
     * @param OrderRepository $orderRepo
     * 
     * @return Response
     *
     *
     */

    #[Route('/orders', name: 'app_orders')]
    public function index(Request $request, OrderRepository $orderRepo): Response
    {
        $myForm = $this->createForm(
            ConsumeApiType::class,
            options: [
                'action' => $this->generateUrl('app_flow'),
                'method' => 'GET',
                'attr' => ['target' => '_blank']
            ]
        );
        $page = $request->query->getInt("page", 1);
        $orders = [];
        $pages = 1;
        $limit = 4;
        $response = $orderRepo->paginationQuery($page, $limit);
        if (!empty($response)) {
            $orders = $response["data"];
            $pages = $response["pages"];
        }
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
            'currentPage' => $page,
            'pages' => $pages,
            'limit' => $limit,
            'path' => 'app_orders',
            'myForm' => $myForm->createView()
        ]);
    }

    /**
     * Elle retourne un fichier csv contenant la liste des commandes sauvegardé dans la base de données  
     *
     * @param Request $request 
     * 
     * @param LoadDataService $loadDataService 
     * 
     * @param SaveDataService $saveDataService 
     * 
     * @param CsvFileManipulationService $csvFileManipulationService 
     * 
     * @return Response 
     * 
     *
     */

    #[Route('/flow/orders_to_csv', name: 'app_flow', methods: ["GET"])]
    public function ordersToCsv(Request $request, LoadDataService $loadDataService, SaveDataService $saveDataService, CsvFileManipulationService $csvFileManipulationService): Response
    {
        $myForm = $this->createForm(
            ConsumeApiType::class,
            options: [
                'action' => $this->generateUrl('app_flow'),
                'method' => 'GET',
                'attr' => ['target' => '_blank']
            ]
        );
        $myForm->handleRequest($request);
        if ($myForm->isSubmitted() && $myForm->isValid()) {
            $data = $myForm->getData();
            $url = $data["apiUrl"];
            $key = $data["apiKey"];
            $response = $loadDataService->loadDataFromAnApi($url, $key);
            $result = false;
            if (str_contains($url, "contact")) {
                $result = $saveDataService->saveContacts($response);
            } else {
                if (str_contains($url, "order")) {
                    $result = $saveDataService->saveOrders($response);
                }
            }
            if ($result) {
                $csvFileManipulationService->fetchOrders("orders.csv");
            }
        }
        return $this->render('empty/empty.html.twig', []);
    }
}
