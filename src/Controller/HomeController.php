<?php

namespace App\Controller;

use App\Service\LoadDataService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LoadDataService $loadDataService): Response
    {
        dd($loadDataService->getContacts(),$loadDataService->getOrders());
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
