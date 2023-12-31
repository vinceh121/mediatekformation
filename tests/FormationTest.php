<?php
namespace App\Tests;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormationTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testPublishedDateString(): void
    {
        $form = new Formation();
        $this->assertEquals('', $form->getPublishedAtString());

        $form->setPublishedAt(\DateTime::createFromFormat(\DateTime::ISO8601, '2023-10-20T15:02:33Z'));
        $this->assertEquals('20/10/2023', $form->getPublishedAtString());
    }

    public function testRepoLatest(): void
    {
        /** @var $repo \App\Repository\FormationRepository */
        $repo = self::getContainer()->get('App\Repository\FormationRepository');

        $res = $repo->findAllLasted(2);

        $this->assertEquals('title 3', $res[0]->getTitle());
        $this->assertEquals('title 2', $res[1]->getTitle());
    }

    public function testRepoPlaylist(): void
    {
        /** @var $repo \App\Repository\PlaylistRepository */
        $playRepo = self::getContainer()->get('App\Repository\PlaylistRepository');

        /** @var $repo \App\Repository\FormationRepository */
        $formRepo = self::getContainer()->get('App\Repository\FormationRepository');

        $playlist = $playRepo->findBy([
            'name' => 'My playlist'
        ])[0];

        $forms = $formRepo->findAllForOnePlaylist($playlist->getId());

        $this->assertEquals('title 1', $forms[0]->getTitle());
        $this->assertEquals('title 2', $forms[1]->getTitle());
        $this->assertEquals('title 3', $forms[2]->getTitle());
    }
}
