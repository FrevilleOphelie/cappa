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
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nom'),
            TextField::new('dateNaissance'),
            TextField::new('description'),
            BooleanField::new('adopte')->setLabel('Adopté')->renderAsSwitch(),
            BooleanField::new('parraine')->setLabel('Parrainné')->renderAsSwitch(),
            TextField::new('marraine'),
        ];
    }
}
