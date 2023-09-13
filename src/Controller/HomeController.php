<?php

namespace App\Controller;

use App\Service\LoadDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/store', name: 'app_store')]
    public function index(LoadDataService $loadDataService): Response
    {
        $contacts=$loadDataService->getContacts();
        $orders=$loadDataService->getOrders();
        dd($contacts,$orders);
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
