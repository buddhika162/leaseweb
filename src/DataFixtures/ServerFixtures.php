<?php

namespace App\DataFixtures;

use App\Entity\Server;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $server = new Server();
        $server->setAssetId(123456);
        $server->setName("RE201");
        $server->setBrand("Dell");
        $server->setPrice(600);
        $manager->persist($server);

        $server2 = new Server();
        $server2->setAssetId(234567);
        $server2->setName("RE202");
        $server2->setBrand("Acer");
        $server2->setPrice(500);
        $manager->persist($server2);

        $manager->flush();

        $this->addReference("server1", $server);
        $this->addReference("server2", $server2);
    }
}