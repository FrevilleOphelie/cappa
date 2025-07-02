<?php

namespace ChatCrudController;

use App\Entity\Chat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chat::class;
    }

public function configureFields(string $pageName): iterable
    {
        return [
            // Ne pas afficher le champ ID
            IdField::new('id')
                ->hideOnForm(),
            // Champs obligatoires
            TextField::new('nom')
                ->setRequired(true)
                ->setLabel('Nom du chat'),
            TextField::new('description')
                ->setRequired(true)
                ->setLabel('Description'),
            TextField::new('dateNaissance')
                ->setRequired(true)
                ->setLabel('Né(e) le (ou date approximative)'),
            BooleanField::new('adopte')
                ->setRequired(true)
                ->setLabel('À adopter'),
            BooleanField::new('parrainne')
                ->setRequired(true)
                ->setLabel('Chat parrainé'),
            //Champ facultatif
            TextField::new('marraine')
                ->setLabel('Prénom de la marraine ou du parrain'),
        ];
    }
}
