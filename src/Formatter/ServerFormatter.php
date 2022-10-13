<?php

namespace App\Formatter;

use App\Entity\Server;

class ServerFormatter extends BaseFormatter
{
    function formatObject($server): array
    {
        $serverArray['id'] = $server->getId();
        $serverArray['assetId'] = $server->getAssetId();
        $serverArray['name'] = $server->getName();
        $serverArray['brand'] = $server->getBrand();
        $serverArray['price'] = $server->getPrice();
        $ramModules = $server->getServerRamModules();
        foreach ($ramModules as $ramModule) {
            $ramModuleArray['ramModuleId'] = $ramModule->getId();
            $ramModuleArray['ramId'] = $ramModule->getRam()->getId();
            $ramModuleArray['type'] = $ramModule->getRam()->getType();
            $ramModuleArray['size'] = $ramModule->getRam()->getSize();
            $serverArray['ramModules'][] = $ramModuleArray;
        }

        return $serverArray;
    }
}