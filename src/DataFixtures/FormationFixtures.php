<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class FormationFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager): void
    {
        $form = new Formation();
        $form->setDescription('Desc');
        $form->setTitle('title');
        $form->setPublishedAt(new \DateTime());
        $form->setVideoId('jNQXAC9IVRw');
        $manager->persist($form);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'test'
        ];
    }
}
