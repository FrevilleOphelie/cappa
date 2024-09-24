<?php

namespace App\Controller;

use App\Repository\ChatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chats')]
class ChatsController extends AbstractController
{
    #[Route('/', name: 'app_chats')]
    public function index(ChatsRepository $chatsRepository): Response
    {
        return $this->render('chats/index.html.twig', [
            'chats' => $chatsRepository->findAll(),
        ]);
    }
}
