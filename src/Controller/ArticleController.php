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

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cette classe  permet de répondre les requêtes demandant la ressource Article
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class ArticleController extends AbstractController
{
    /**
     * Elle retourne la  page articles contant la liste des articles paginé chargé de la base de données
     *
     * @param Request $request
     * 
     * @param ArticleRepository $articleRepo 
     * 
     * @return Response 
     *
     *
     */

    #[Route('/articles', name: 'app_articles')]
    public function index(Request $request, ArticleRepository $articleRepo): Response
    {
        //Récupération du numéro de la page actuelle
        $page = $request->query->getInt("page", 1);
        $articles = [];
        $pages = 1;
        $limit = 4;
        //Récupération de la liste des articles paginé
        $response = $articleRepo->paginationQuery($page, $limit);
        if (!empty($response)) {
            $articles = $response["data"];
            $pages = $response["pages"];
        }
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'currentPage' => $page,
            'pages' => $pages,
            'limit' => $limit,
            'path' => 'app_articles'
        ]);
    }
}
