<?php

namespace App\Controller\Admin;

use App\Entity\Chats;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            TextField::new(''),
        ];
    }
}
