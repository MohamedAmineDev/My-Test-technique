<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use App\Service\LoadDataService;
use App\Service\SaveDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private ContactRepository $contactRepo;
    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepo=$contactRepo;
    }
    #[Route('/store', name: 'app_store')]
    public function index(LoadDataService $loadDataService,SaveDataService $saveDataService): Response
    {
        $contacts=$loadDataService->getContacts();
        $orders=$loadDataService->getOrders();
        //dd($contacts,$orders);
        $test=$saveDataService->saveContacts($contacts);
        $contacts=$this->contactRepo->findAll();
        dd($test,$contacts);
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
