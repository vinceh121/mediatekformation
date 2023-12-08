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
        $form->setDescription('Desc 1');
        $form->setTitle('title 1');
        $form->setPublishedAt(new \DateTime());
        $form->setVideoId('jNQXAC9IVRw');
        $form->setPlaylist($this->getReference(PlaylistFixtures::MY_PLAYLIST_REF));
        $manager->persist($form);

        $form = new Formation();
        $form->setDescription('Desc 2');
        $form->setTitle('title 2');
        $form->setPublishedAt((new \DateTime())->add(\DateInterval::createFromDateString('2 weeks')));
        $form->setVideoId('XqZsoesa55w');
        $form->setPlaylist($this->getReference(PlaylistFixtures::MY_PLAYLIST_REF));
        $manager->persist($form);

        $form = new Formation();
        $form->setDescription('Desc 3');
        $form->setTitle('title 3');
        $form->setPublishedAt((new \DateTime())->add(\DateInterval::createFromDateString('4 weeks')));
        $form->setVideoId('9bZkp7q19f0');
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
