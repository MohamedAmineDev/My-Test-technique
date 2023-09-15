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
        //Création d'un formulaire pour la saisie d'un api
        $myForm = $this->createForm(
            ConsumeApiType::class,
            options: [
                'action' => $this->generateUrl('app_flow'),
                'method' => 'GET',
                'attr' => ['target' => '_blank']
            ]
        );
        //Récupération du numéro de la page actuelle
        $page = $request->query->getInt("page", 1);
        $orders = [];
        $pages = 1;
        $limit = 4;
        //Récupération de la liste des commandes paginé
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
        //Création d'un formulaire pour la saisie d'un api
        $myForm = $this->createForm(
            ConsumeApiType::class,
            options: [
                'action' => $this->generateUrl('app_flow'),
                'method' => 'GET',
                'attr' => ['target' => '_blank']
            ]
        );
        //Récupération les valeurs des champs dans les inputs du formulaire
        $myForm->handleRequest($request);
        //On teste si le formulaire est valide et a été soumis
        if ($myForm->isSubmitted() && $myForm->isValid()) {
            $data = $myForm->getData();
            //On récupère l'url  et la clé de l'api du formulaire soumis
            $url = $data["apiUrl"];
            $key = $data["apiKey"];
            //On consomme l'api
            $response = $loadDataService->loadDataFromAnApi($url, $key);
            $result = false;
            //Si la ressource demandée est contact alors on sauvegarde les nouveaux contacts
            if (str_contains($url, "contact")) {
                $result = $saveDataService->saveContacts($response);
            } else {
                //Si la ressource demandée est order alors on sauvegarde les nouvelles commandes
                if (str_contains($url, "order")) {
                    $result = $saveDataService->saveOrders($response);
                }
            }
            //Si la sauvegarde est un succès alors on génére un fichier csv
            if ($result) {
                $csvFileManipulationService->fetchOrders("orders.csv");
            }
        }
        return $this->render('empty/empty.html.twig', []);
    }
}
