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

use App\Repository\ContactRepository;
use App\Repository\OrderRepository;
use App\Repository\SalesOrderLineRepository;
use App\Service\CsvFileManipulationService;
use App\Service\LoadDataService;
use App\Service\SaveDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * La classe  permet de gérer les requêtes vers /home
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class HomeController extends AbstractController
{
    private ContactRepository $contactRepo;
    private OrderRepository $orderRepo;
    private SalesOrderLineRepository $salesOrderLineRepository;

    public function __construct(ContactRepository $contactRepo, OrderRepository $orderRepo, SalesOrderLineRepository $salesOrderLineRepository)
    {
        $this->contactRepo = $contactRepo;
        $this->orderRepo = $orderRepo;
        $this->salesOrderLineRepository = $salesOrderLineRepository;
    }
/*
    #[Route('/contacts', name: 'app_contacts')]
    public function contacts(LoadDataService $loadDataService, SaveDataService $saveDataService): Response
    {
        $contacts = $loadDataService->loadDataFromAnApi(
            "https://internshipapi-pylfsebcoa-ew.a.run.app/contacts",
            "PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b"
        );
        $test = $saveDataService->saveContacts($contacts);
        $savedContacts = $this->contactRepo->findAll();
        dd($contacts, $test, $savedContacts);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/orders', name: 'app_orders')]
    public function orders(LoadDataService $loadDataService, SaveDataService $saveDataService): Response
    {
        $orders = $loadDataService->loadDataFromAnApi(
            "https://internshipapi-pylfsebcoa-ew.a.run.app/orders",
            "PMAK-62642462da39cd50e9ab4ea7-815e244f4fdea2d2075d8966cac3b7f10b"
        );
        $test = $saveDataService->saveOrders($orders);
        $savedOrders = $this->orderRepo->findAll();
        $salesOrderLines=$this->salesOrderLineRepository->findAll();
        dd($orders, $test, $savedOrders,$salesOrderLines);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
*/

 /**
     * Retourner une page d'accueil
     *
     * @return Response retourne une page web home rendu coté serveur
     *
     *
     */

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }

/**
     * Redirige vers la  page d'accueil
     *
     * @return Response retourne vers l'url /home
     *
     *
     */

    #[Route('/', name: 'app_redirector')]
    public function redirection(): Response
    {
        return $this->redirect("/home");
    }
}
