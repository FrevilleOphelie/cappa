<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Form\ChatForm;
use App\Repository\ChatRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chat')]
final class ChatController extends AbstractController
{
    #[Route(name: 'app_chat_index', methods: ['GET'])]
    public function index(ChatRepository $chatRepository): Response
    {
        return $this->render('chat/index.html.twig', [
            'chats' => $chatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ImageUploader $imageUploader, EntityManagerInterface $entityManager): Response
    {
        //Interdire l'accès aux non-connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        $chat = new Chat();
        $form = $this->createForm(ChatForm::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $photoFileName = $imageUploader->upload($photoFile);
                $chat->setPhotoFilename($photoFileName);
            }

            $entityManager->persist($chat);
            $entityManager->flush();

            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat/new.html.twig', [
            'chat' => $chat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        //Interdire l'accès aux non-connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(ChatForm::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat/edit.html.twig', [
            'chat' => $chat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_chat_delete', methods: ['POST'])]
    public function delete(Request $request, Chat $chat, EntityManagerInterface $entityManager): Response
    {
        //Interdire l'accès aux non-connectés
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->isCsrfTokenValid('delete'.$chat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chat_index', [], Response::HTTP_SEE_OTHER);
    }
}
