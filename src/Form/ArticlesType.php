<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Tag;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticlesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Le titre de votre post ...'))
            ->add('content', TextareaType::class, $this->getConfiguration('Le contenu de votre article ...'))
            ->add('date')
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'themeName',
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Choisisser un thème ...'
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'tagName',
                'label' => false,
                'multiple' => true,
                'expanded' => true,
                'placeholder' => 'Choisisser un tag ...'
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Sélectionner une image de couverture ...'
                ]
            ])
    ;
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
