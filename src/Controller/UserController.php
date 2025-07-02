<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Restreindre l'accès au aux roles admin et superadmin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Restreindre l'accès aux roles admin et superadmin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            if ($this->isGranted('ROLE_SUPERADMIN')) {
                // Définir les rôles sélectionnés dans le formulaire
                $roles = $form->get('roles')->getData();
                if (is_array($roles)) {
                    $user->setRoles($roles);
                }
            }

            if (!$this->isGranted('ROLE_SUPERADMIN')) {
                $user->setRoles(['ROLE_USER']);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $currentUser = $this->getUser();

        // Restreindre l'accès au SuperAdmin et au user concerné par la page
        if ($currentUser === $user || $this->isGranted('ROLE_SUPERADMIN')) {
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        } else {
            throw new AccessDeniedException('Vous n\'avez pas accès à cette page.');
        }
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $currentUser = $this->getUser();

        // Restreindre l'accès au SuperAdmin et au user concerné par la page
        if ($currentUser === $user || $this->isGranted('ROLE_SUPERADMIN')) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Si le mot de pass a été édité on le met à jour
                if ($form->get('password')->getData() !== '') {
                    // Hashage du mot de passe
                    $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
                    $user->setPassword($hashedPassword);
                } else {
                    // Si le mot de passe n'est pas édité, on récupère le mot de passe actuel de l'utilisateur
                    $currentPassword = $user->getPassword();
                    // Remettre le mot de passe actuel en base de données pour ne pas vider le champ
                    $user->setPassword($currentPassword);
                }

                $entityManager->flush();

                return $this->redirectToRoute('app_user_index');
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

        throw new AccessDeniedException('Vous n\'avez pas accès à cette page.');
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_SUPERADMIN')) {
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                $entityManager->remove($user);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_user_index');
        }

        throw new AccessDeniedException('Vous n\'avez pas accès à cette page.');
    }
}
