<?php
namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use App\Entity\Playlist;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('publishedAt', DateTimeType::class, [
            'label' => 'Publié le'
        ])
            ->add('title', TextType::class, [
            'label' => 'Titre'
        ])
            ->add('description', TextareaType::class)
            ->add('videoId', TextType::class, [
            'label' => 'ID Video'
        ])
            ->add('playlist', EntityType::class, [
            'class' => Playlist::class,
            'choices' => $options['playlists'],
            'choice_label' => function (Playlist $playlist): string {
                return $playlist->getName();
            }
        ])
            ->add('categories', EntityType::class, [
            'class' => Categorie::class,
            'choices' => $options['categories'],
            'choice_label' => function (Categorie $category): string {
                return $category->getName();
            },
            'expanded' => true,
            'multiple' => true
        ])
            ->add('submit', SubmitType::class, [
            'label' => 'Modifier'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
            'playlists' => [],
            'categories' => []
        ]);
    }
}
