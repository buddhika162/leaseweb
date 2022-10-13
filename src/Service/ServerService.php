<?php

namespace App\Service;

use App\Entity\RamModule;
use App\Entity\Server;
use App\Entity\ServerRamModule;
use App\Repository\RamModuleRepository;
use App\Repository\ServerRepository;

class ServerService
{
    public function __construct(private ServerRepository $serverRepository,
                                private RamModuleRepository $ramModuleRepository) {
    }

    public function setServerRepository(ServerRepository $serverRepository): void
    {
        $this->serverRepository = $serverRepository;
    }

    public function getServerRepository(): ServerRepository
    {
        return $this->serverRepository;
    }

    public function setRamModuleRepository(RamModuleRepository $ramModuleRepository): void
    {
        $this->ramModuleRepository = $ramModuleRepository;
    }

    public function getRamModuleRepository(): RamModuleRepository
    {
        return $this->ramModuleRepository;
    }

    public function createAndSave($request): Server
    {
        $params = json_decode($request->getContent(), true);
        $server = new Server();
        $server->setAssetId($params['assetId']);
        $server->setName($params['name']);
        $server->setBrand($params['brand']);
        $server->setPrice($params['price']);
        $ramModules = $params['ramModules'];
        foreach ($ramModules as $ramModule) {
            $ramModule = $this->getRamModuleRepository()->findOneBy(['id' => $ramModule]);
            $serverRamModule = new ServerRamModule();
            $serverRamModule->setRam($ramModule);
            $server->addServerRamModule($serverRamModule);
        }
        $this->getServerRepository()->save($server);
        return $server;
    }

    public function deleteMultipleByAssetId($request) : int
    {
        $params = json_decode($request->getContent(), true);
        return $this->getServerRepository()->deleteMultipleByAssetId($params['assetIds']);
    }

}