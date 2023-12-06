<?php
namespace App\DataFixtures;

use App\Entity\Playlist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class PlaylistFixtures extends Fixture implements FixtureGroupInterface
{

    public const MY_PLAYLIST_REF = 'my-playlist';

    public function load(ObjectManager $manager)
    {
        $playlist = new Playlist();
        $playlist->setName("My playlist");
        $playlist->setDescription("Description here");

        $manager->persist($playlist);
        $manager->flush();

        $this->addReference(self::MY_PLAYLIST_REF, $playlist);
    }

    public static function getGroups(): array
    {
        return [
            'test'
        ];
    }
}

