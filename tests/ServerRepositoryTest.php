<?php

namespace App\Tests;

use App\DataFixtures\RamModuleFixtures;
use App\DataFixtures\ServerFixtures;
use App\DataFixtures\ServerRamModuleFixtures;
use App\Entity\Server;
use App\Repository\ServerRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServerRepositoryTest extends FixtureAwareTestCase
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
        $this->addFixture(new RamModuleFixtures());
        $this->addFixture(new ServerFixtures());
        $this->addFixture(new ServerRamModuleFixtures());
        $this->executeFixtures();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
    }

    /*
     *
     */
    public function testSave()
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

    public function testGetAll()
    {

        $serverRepository = new ServerRepository($this->managerRegistery);
        $servers = $serverRepository->getAll();
        $this->assertEquals(2,count($servers));

        $this->assertEquals(123456,$servers[0]->getAssetId());
        $this->assertEquals("RE201",$servers[0]->getName());
        $this->assertEquals("Dell",$servers[0]->getBrand());
        $this->assertEquals(600,$servers[0]->getPrice());

        $server1RamModules = $servers[0]->getServerRamModules();

        $this->assertEquals(2,count($server1RamModules));

        $this->assertEquals(1,$server1RamModules[0]->getRam()->getId());

        $this->assertEquals(2,$server1RamModules[1]->getRam()->getId());

        $this->assertEquals(234567,$servers[1]->getAssetId());
        $this->assertEquals("RE202",$servers[1]->getName());
        $this->assertEquals("Acer",$servers[1]->getBrand());
        $this->assertEquals(500,$servers[1]->getPrice());

        $server2RamModules = $servers[1]->getServerRamModules();

        $this->assertEquals(1,count($server2RamModules));

        $this->assertEquals(2,$server2RamModules[0]->getRam()->getId());
    }


    public function testRemove()
    {

        $serverRepository = new ServerRepository($this->managerRegistery);
        $servers = $serverRepository->getAll();
        $this->assertEquals(2,count($servers));
        $serverRepository->remove($servers[1]);
        $servers = $serverRepository->getAll();
        $this->assertEquals(1,count($servers));

        $this->assertEquals(123456,$servers[0]->getAssetId());
        $this->assertEquals("RE201",$servers[0]->getName());
        $this->assertEquals("Dell",$servers[0]->getBrand());
        $this->assertEquals(600,$servers[0]->getPrice());
    }

}