<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
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
