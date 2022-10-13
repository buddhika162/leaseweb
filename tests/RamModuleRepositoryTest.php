<?php

namespace App\Tests;

use App\DataFixtures\RamModuleFixtures;
use App\DataFixtures\ServerFixtures;
use App\DataFixtures\ServerRamModuleFixtures;
use App\Entity\RamModule;
use App\Repository\RamModuleRepository;
use Doctrine\ORM\EntityManagerInterface;

class RamModuleRepositoryTest extends FixtureAwareTestCase
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
        $ramModule = new RamModule();
        $ramModule->setType("test");
        $ramModule->setSize(2);

        $ramModuleRepository = new RamModuleRepository($this->managerRegistery);
        $ramModuleRepository->save($ramModule);
        $savedRamModule = $ramModuleRepository->findOneBy(['type' => 'test']);
        $this->assertNotNull($savedRamModule->getId());
        $this->assertEquals("test",$savedRamModule->getType());
        $this->assertEquals(2,$savedRamModule->getSize());
    }

    public function testGetAll()
    {

        $ramModuleRepository = new RamModuleRepository($this->managerRegistery);
        $ramModules = $ramModuleRepository->getAll();
        $this->assertEquals(2,count($ramModules));

        $this->assertEquals("DDR3",$ramModules[0]->getType());
        $this->assertEquals(2,$ramModules[0]->getSize());


        $this->assertEquals("DDR4",$ramModules[1]->getType());
        $this->assertEquals(4,$ramModules[1]->getSize());

    }


    public function testRemove()
    {

        $ramModuleRepository = new RamModuleRepository($this->managerRegistery);
        $ramModules = $ramModuleRepository->getAll();
        $this->assertEquals(2,count($ramModules));
        $ramModuleRepository->remove($ramModules[1]);
        $ramModules = $ramModuleRepository->getAll();
        $this->assertEquals(1,count($ramModules));

        $this->assertEquals("DDR3",$ramModules[0]->getType());
        $this->assertEquals(2,$ramModules[0]->getSize());
    }

}