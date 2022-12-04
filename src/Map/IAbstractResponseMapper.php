<?php

namespace App\Map;

interface IAbstractResponseMapper
{
    public function mapFromObject($object);
    public function mapFromObjects(iterable $objects): iterable;
}