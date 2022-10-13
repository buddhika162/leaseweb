<?php

namespace App\DataFixtures;


use App\Entity\ServerRamModule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServerRamModuleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $serverRamModule = new ServerRamModule();
        $serverRamModule->setRam($this->getReference("ramModule1"));
        $serverRamModule->setServer($this->getReference("server1"));
        $manager->persist($serverRamModule);

        $serverRamModule2 = new ServerRamModule();
        $serverRamModule2->setRam($this->getReference("ramModule2"));
        $serverRamModule2->setServer($this->getReference("server1"));
        $manager->persist($serverRamModule2);

        $serverRamModule3 = new ServerRamModule();
        $serverRamModule3->setRam($this->getReference("ramModule2"));
        $serverRamModule3->setServer($this->getReference("server2"));
        $manager->persist($serverRamModule3);

        $manager->flush();
    }
}