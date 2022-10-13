<?php

namespace App\Service;

use App\Entity\RamModule;
use App\Repository\RamModuleRepository;

class RamModuleService
{
    public function __construct(private RamModuleRepository $ramModuleRepository) {
    }

    public function setRamModuleRepository(RamModuleRepository $ramModuleRepository): void
    {
        $this->ramModuleRepository = $ramModuleRepository;
    }

    public function getRamModuleRepository(): RamModuleRepository
    {
        return $this->ramModuleRepository;
    }

    public function createAndSave($request): RamModule
    {
        $params = json_decode($request->getContent(), true);
        $ramModule = new RamModule();
        $ramModule->setSize($params['size']);
        $ramModule->setType($params['type']);
        $this->getRamModuleRepository()->save($ramModule);
        return $ramModule;
    }

}