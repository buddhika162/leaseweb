<?php

namespace App\Formatter;


class RamModuleFormatter extends BaseFormatter
{

    public function formatObject($ramModule): array
    {
        $ramModuleArray['id'] = $ramModule->getId();
        $ramModuleArray['type'] = $ramModule->getType();
        $ramModuleArray['size'] = $ramModule->getsize();

        return $ramModuleArray;
    }

}