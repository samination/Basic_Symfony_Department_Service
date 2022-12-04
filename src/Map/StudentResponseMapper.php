<?php

namespace App\Map;

use App\Dto\StudentResponseDto;
use App\Entity\Student;
use App\Exception\Handler\UnexpectedTypeException;


class StudentResponseMapper extends AbstractResponseMapper
{
    /**
     * @param Student $object
     *
     * @return StudentResponseDto
     */
    public function mapFromObject($object) : StudentResponseDto
    {
        if (!$object instanceof Student) {
            throw new UnexpectedTypeException('Expected type of Customer but got ' . \get_class($object));
        }

        $studentDTO=new StudentResponseDto();
        $studentDTO->setEmail($object->getEmail());
        $studentDTO->setName($object->getName());
        $studentDTO->setGrade($object->getGrade());

        return $studentDTO;

    }
}