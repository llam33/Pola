<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ArticleCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(ArticleCrudController::class)->generateUrl());
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pola');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Article', 'fa fa-list');
        yield MenuItem::linkToCrud('Article', 'fas fa-pen-fancy', Article::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-pen-fancy', Category::class);
        yield MenuItem::linkToCrud('Menu', 'fas fa-pen-fancy', Menu::class);
        yield MenuItem::linkToRoute('Mon profil', 'fas fa-user', 'profile');
        yield MenuItem::linkToRoute('Accueil du site', 'fas fa-angle-double-down', 'home');
        yield MenuItem::linkToRoute('Déconnexion', 'fas fa-sign-out-alt', 'app_logout');
    }
}
