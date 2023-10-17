<?php
namespace App\Form;

use App\Entity\Formation;
use App\Entity\Playlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;

class PlaylistType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class)
            ->add('description', TextareaType::class, [
            'attr' => [
                'rows' => 10
            ]
        ])
            ->add('formations', ChoiceType::class, [
            'choices' => $options['formations'],
            'row_attr' => [
                'class' => 'd-none'
            ],
            'choice_label' => function (Formation $formation): string {
                return $formation->getTitle();
            },
            'choice_attr' => function (Formation $formation): array {
                return [
                    'data-thumbnail' => $formation->getMiniature()
                ];
            },
            'choice_value' => 'id',
            'multiple' => true,
            'required' => false
        ])
            ->add('submit', SubmitType::class, [
            'label' => 'Modifier'
        ]);

        $builder->get('formations')->addViewTransformer(new CallbackTransformer(function ($collection) {
            return array_map(fn ($x) => $x->getId(), $collection->getValues());
        }, fn ($collection) => $collection), true);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
            'formations' => []
        ]);
    }
}
