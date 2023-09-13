<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Repository\OrderRepository;
use App\Repository\SalesOrderLineRepository;
use App\Service\LoadDataService;
use App\Service\SaveDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ContactRepository $contactRepo;
    private OrderRepository $orderRepo;
    private SalesOrderLineRepository $salesOrderLineRepository;
    public function __construct(ContactRepository $contactRepo,OrderRepository $orderRepo,SalesOrderLineRepository $salesOrderLineRepository)
    {
        $this->contactRepo=$contactRepo;
        $this->orderRepo=$orderRepo;
        $this->salesOrderLineRepository=$salesOrderLineRepository;
    }
    #[Route('/store', name: 'app_store')]
    public function index(LoadDataService $loadDataService,SaveDataService $saveDataService): Response
    {
        $contacts=$loadDataService->getContacts();
        $orders=$loadDataService->getOrders();
        dd($contacts,$orders);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/save_data', name: 'app_save_data')]
    public function saveData(LoadDataService $loadDataService,SaveDataService $saveDataService): Response
    {
        $contacts=$loadDataService->getContacts();
        $orders=$loadDataService->getOrders();
        $test=$saveDataService->saveContacts($contacts);
        $test2=$saveDataService->saveOrders($orders);
        dd($this->orderRepo->findAll(),$this->salesOrderLineRepository->findAll());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/', name: 'app_home')]
    public function redirection(LoadDataService $loadDataService): Response
    {
        return $this->redirect("/store");
    }
    
}
