<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('role', EntityType::class, [
//                'class' => Status::class,
//                'choice_label' => 'status',
//                'expanded' => true,
//                'multiple' => false,
//                'label' => false,
//            ])
            ->add('pseudo', TextType::class, $this->getConfiguration("Votre pseudo ..."))
            ->add('mail', EmailType::class, $this->getConfiguration("Votre adresse mail ..."))
            ->add('avatar', UrlType::class, $this->getConfiguration("URL de votre avatar ..."))
            ->add('hash', PasswordType::class, $this->getConfiguration("Votre mot de passe ..."))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmez votre motre de passe ..."))
            ->add('description', TextType::class, $this->getConfiguration("Une description en quelques mots ..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
