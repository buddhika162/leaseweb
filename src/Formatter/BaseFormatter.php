<?php

namespace App\Formatter;

abstract class BaseFormatter
{

    public function formatObjects($objects): array
    {
        $dataArray = [];
        foreach ($objects as $object) {
            $dataArray[] = $this->formatObject($object);
        }
        return $dataArray;
    }
    abstract function formatObject($object): array;

}