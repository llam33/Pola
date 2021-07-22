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

    /**
     * @Route("/category/{id}", name="categoryShow")
     * 
     */
    public function showCategory(CategoryRepository $categoryRepository, $id): Response
    {
        $category = $categoryRepository->find($id);

        $articles = $category->getArticles();

        switch ($id) {
            case 1:
                return $this->render('category/entrees.html.twig',[
                    'articles' => $articles,
                ]);
                break;
            case 2:
                return $this->render('category/plats.html.twig',[
                    'articles' => $articles,
                ]);
            case 3:
                return $this->render('category/desserts.html.twig',[
                    'articles' => $articles,
                ]);
        }

        
    }

    
}
