<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NewsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('date_heure')
            ->add('description')
            ->add('lieu')
            ->add('image', FileType::class, [
                'label'=>'Image',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File(
                        maxSize: '1024k',
                        extensions: ['pdf', 'jpeg', 'jpg', 'png'],
                        extensionsMessage: 'L\'image doit être au format PDF, JPEG ou PNG',
                    )
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
