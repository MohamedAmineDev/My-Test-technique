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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cette classe  permet de répondre les requêtes demandant la ressource Contact
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class ContactController extends AbstractController
{

    /**
     * Elle retourne la  page contacts contant la liste des contacts paginé chargé de la base de données
     *
     * @param Request $request
     * 
     * @param ContactRepository $contactRepo 
     * 
     * @return Response 
     *
     *
     */

    #[Route('/contacts', name: 'app_contacts')]
    public function index(Request $request, ContactRepository $contactRepo): Response
    {
        //Récupération du numéro de la page actuelle
        $page = $request->query->getInt("page", 1);
        $contacts = [];
        $pages = 1;
        $limit = 4;
        //Récupération de la liste des contacts paginé
        $response = $contactRepo->paginationQuery($page, $limit);
        if (!empty($response)) {
            $contacts = $response["data"];
            $pages = $response["pages"];
        }
        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
            'currentPage' => $page,
            'pages' => $pages,
            'limit' => $limit,
            'path' => 'app_contacts'
        ]);
    }
}
