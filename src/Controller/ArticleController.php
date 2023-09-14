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

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(Request $request,ArticleRepository $articleRepo): Response
    {
        $page=$request->query->getInt("page",1);
        $response=$articleRepo->paginationQuery($page,4);
        $articles=$response["data"];
        $currentPage=$response["page"];
        $pages=$response["pages"];
        $limit=$response["limit"];
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'limit' => $limit,
            'path'=>'app_articles'
        ]);
    }
}
