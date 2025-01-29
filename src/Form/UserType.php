<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUserRoles = $this->security->getUser()->getRoles();

        $builder
            ->add('identifiant')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe'],
            ]);

        // Ajoutez le champ "roles" seulement si l'utilisateur est un super administrateur
        if (in_array('ROLE_SUPERADMIN', $currentUserRoles)) {
            $defaultRoles = in_array('ROLE_ADMIN', $currentUserRoles) ? ['ROLE_ADMIN'] : [];
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'label' => 'Rôle',
                'multiple' => true, // permettre une seule sélection
                'expanded' => true, // afficher les choix sous forme de boutons radio
                'data' => $defaultRoles, // définir la valeur par défaut sur le tableau de rôles par défaut
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}