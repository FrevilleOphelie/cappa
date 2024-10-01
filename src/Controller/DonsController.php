<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DonsController extends AbstractController
{
    #[Route('/dons', name: 'app_dons')]
    public function index(): Response
    {
        return $this->render('dons/index.html.twig', [
            'controller_name' => 'DonsController',
        ]);
    }
}
