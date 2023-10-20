<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;

class FormationTest extends TestCase
{
    public function testSomething(): void
    {
        $form = new Formation();
        $this->assertEquals('', $form->getPublishedAtString());
        
        $form->setPublishedAt(\DateTime::createFromFormat(\DateTime::ISO8601, '2023-10-20T15:02:33Z'));
        $this->assertEquals('20/10/2023', $form->getPublishedAtString());
    }
}
