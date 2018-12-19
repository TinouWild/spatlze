<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Tag;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Le titre de votre post ...'))
            ->add('content')
            ->add('date')
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'choice_label' => 'theme_name',
                'label' => false,
                'placeholder' => 'Choisisser un thème ...'
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'tag_name',
                'label' => false,
                'placeholder' => 'Choisisser un tag ...'
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
