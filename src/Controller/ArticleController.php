<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findByAll();
        dump($articles);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    

    
}
