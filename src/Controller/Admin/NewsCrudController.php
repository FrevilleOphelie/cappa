<?php

namespace App\Controller\Admin;

use App\Entity\News;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return News::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //Cacher le champ Id
            IdField::new('id')
                ->hideOnForm(),
            //Champs Obligatoires
            TextField::new('type')
                ->setRequired(true)
                ->setLabel('Intitulé'),
            TextField::new('description')
                ->setRequired(true)
                ->setLabel('Description'),
            //Champs Facultatifs
            TextField::new('date_heure')
                ->setLabel('Date et heure'),
            TextField::new('image')
                ->setLabel('Image'),
            TextField::new('lieu')
                ->setLabel('Lieu'),
        ];
    }
}
