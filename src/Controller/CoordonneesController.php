<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoordonneesController extends AbstractController
{
    /**
     * @Route("/coordonnees", name="coordonnees")
     */
    public function index(): Response
    {
        return $this->render('coordonnees/index.html.twig', [
            'controller_name' => 'CoordonneesController',
        ]);
    }
}
