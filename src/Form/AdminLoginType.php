<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminLoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'label_attr' => [
                'class' => 'form-label'
            ],
            'attr' => [
                'class' => 'form-control'
            ]
        ])
            ->add('password', PasswordType::class, [
            'label' => 'Mot-de-passe',
            'label_attr' => [
                'class' => 'form-label'
            ],
            'attr' => [
                'class' => 'form-control'
            ]
        ])
            ->add('login', SubmitType::class, [
                'label' => 'Connexion',
                'attr' => [
                    'class' => 'btn btn-primary float-end'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
