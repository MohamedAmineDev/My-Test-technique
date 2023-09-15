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

/**
 * Cette classe  permet de répondre les requêtes demandant la page d'accueil
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class HomeController extends AbstractController
{


    /**
     * Retourne la  page d'accueil
     *
     * @return Response
     *
     *
     */

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'path' => 'app_home'
        ]);
    }

    /**
     * Redirige vers l'url de la page d'accueil
     *
     * @return Response
     *
     *
     */

    #[Route('/', name: 'app_redirector')]
    public function redirection(): Response
    {
        return $this->redirect("/home");
    }
}
