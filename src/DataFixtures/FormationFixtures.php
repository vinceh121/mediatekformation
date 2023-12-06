<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FormationFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $form = new Formation();
        $form->setDescription('Desc');
        $form->setTitle('title');
        $form->setPublishedAt(new \DateTime());
        $form->setVideoId('jNQXAC9IVRw');
        $form->setPlaylist($this->getReference(PlaylistFixtures::MY_PLAYLIST_REF));

        $manager->persist($form);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaylistFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return [
            'test'
        ];
    }
}
