<?php

namespace App\Tests;

use App\Entity\Server;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServerTest extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get("doctrine")->getManager();
        $this->managerRegistery = $kernel->getContainer()->get("doctrine");
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }

    /*
     *
     */
    public function testGetAllServers()
    {
        $server = new Server();
        $server->setAssetId(123456);
        $server->setBrand("Dell");
        $server->setName("R210");
        $server->setPrice(500);

        $serverRepository = new ServerRepository($this->managerRegistery);
        $serverRepository->save($server);
        $savedServer = $serverRepository->findOneBy(['name' => 'R210']);
        $this->assertNotNull($savedServer->getId());
        $this->assertEquals(123456,$savedServer->getAssetId());
        $this->assertEquals("R210",$savedServer->getName());
        $this->assertEquals("Dell",$savedServer->getBrand());
        $this->assertEquals(500,$savedServer->getPrice());
    }

}