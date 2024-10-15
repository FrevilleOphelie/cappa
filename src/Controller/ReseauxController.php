<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReseauxController extends AbstractController
{
    #[Route('/reseaux', name: 'app_reseaux')]
    public function index(): Response
    {
        return $this->render('reseaux/index.html.twig', [
            'controller_name' => 'ReseauxController',
        ]);
    }
}
