<?php

namespace App\Map;

abstract class AbstractResponseMapper implements IAbstractResponseMapper
{
    public function mapFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->mapFromObject($object);
        }

        return $dto;
    }
}