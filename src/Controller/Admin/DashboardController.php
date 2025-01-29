<?php

namespace App\Controller\Admin;

use App\Entity\Chats;
use App\Entity\News;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/adminouchats', name: 'adminouchats')]
    public function index(): Response
    {
        return $this->render('adminouchats/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cappa');
    }

    public function configureMenuItems(): iterable
    {
        {
            return [
                MenuItem::linkToDashboard('Dashboard', 'fa-solid fa-arrow-rotate-left'),
                MenuItem::linkToRoute('Retour au site', 'fa-solid fa-home', 'app_home'),

                MenuItem::section('Chats'),
                MenuItem::linkToCrud('Gestion des Pensionnaires', 'fa-solide fa-paw', Chats::class),

                MenuItem::section('News'),
                MenuItem::linkToCrud('Gestion des Nouvelles', 'fa-regular fa-newspaper', News::class),

                MenuItem::section('User'),
                MenuItem::linkToCrud('Gestion des Utilisateurs', 'fa-solid fa-user-group', User::class),

            ];
        }
    }
}
