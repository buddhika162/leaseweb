<?php

namespace App\DataFixtures;

use App\Entity\RamModule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RamModuleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ramModule = new RamModule();
        $ramModule->setType("DDR3");
        $ramModule->setSize(2);
        $manager->persist($ramModule);

        $ramModule2 = new RamModule();
        $ramModule2->setType("DDR4");
        $ramModule2->setSize(4);
        $manager->persist($ramModule2);

        $manager->flush();

        $this->addReference("ramModule1", $ramModule);
        $this->addReference("ramModule2", $ramModule2);
    }
}