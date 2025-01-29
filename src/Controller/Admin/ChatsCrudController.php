<?php

namespace App\Controller\Admin;

use App\Entity\Chats;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChatsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chats::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //Cacher le champ Id
            IdField::new('id')
                ->hideOnForm(),
            //Champs obligatoires
            TextField::new('nom')
                ->setRequired(true)
                ->setLabel('Nom'),
            TextField::new('dateNaissance')
            ->setRequired(true)
            ->setLabel('Né(e) le'),
            TextField::new('description')
                ->setRequired(true)
                ->setLabel('Nom'),
            BooleanField::new('adopte')
                ->setLabel('Adopté')
                ->renderAsSwitch(),
            BooleanField::new('parraine')
                ->setLabel('Parrainné')
                ->renderAsSwitch(),
            //Champs facultatifs
            TextField::new('marraine')
                ->setLabel('Prénom marraine'),
        ];
    }
}
