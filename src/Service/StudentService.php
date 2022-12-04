<?php

namespace App\Service;

use App\Dto\StudentResponseDto;
use App\Entity\Student;
use App\Map\StudentResponseMapper;
use App\Repository\StudentRepository;
use phpDocumentor\Reflection\Types\Collection;

class StudentService
{
    private StudentRepository $studentRepository;
    private StudentResponseMapper $studentResponseMapper;

    /**
     * @param StudentRepository $studentRepository
     * @param StudentResponseMapper $studentResponseMapper
     */
    public function __construct(StudentRepository $studentRepository, StudentResponseMapper $studentResponseMapper)
    {
        $this->studentRepository = $studentRepository;
        $this->studentResponseMapper = $studentResponseMapper;
    }


    public function getAllStudents()
    {
        $students=$this->studentRepository->findAll();

        return $this->studentResponseMapper->mapFromObjects($students);
    }

    public function getStudentByName($name)
    {
        $student=$this->studentRepository->findOneBy(['name' => $name]);


        return $this->studentResponseMapper->mapFromObject($student);

    }

}