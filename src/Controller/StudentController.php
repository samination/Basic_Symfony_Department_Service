<?php
namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }


    public function addStudent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $Name = $data['Name'];
        $email = $data['email'];
        $grade = $data['grade'];

        if (empty($Name) || empty($grade) || empty($email) ) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->studentRepository->saveStudent($Name,$grade,$email);

        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/students", name="get_all_students", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $students = $this->studentRepository->findAll( );
        $data = [];

        foreach ($students as $student) {
            $data[] = [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'grade' => $student->getGrade(),
                'email' => $student->getEmail(),

            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/students/{name}", name="get_one_student", methods={"GET"})
     */
    public function get($name): JsonResponse
    {
        $student = $this->studentRepository->findOneBy(['name' => $name]);
            if($student==null){
                return new JsonResponse("Student not Found!", Response::HTTP_NOT_FOUND);
            }
        $data = [
            'id' => $student->getId(),
            'name' => $student->getName(),
            'email' => $student->getEmail(),
            'grade' => $student->getGrade(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("/bestStudent", name="get_best_student", methods={"GET"})
     */
    public function getBestStudent():JsonResponse
    {
        $bestStudents=$this->studentRepository->getBestStudents();

        if($bestStudents==null){
            return new JsonResponse("Students not Found!", Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bestStudents, Response::HTTP_OK);

    }

    /**
     * @Route("/successStudent", name="get_success_student", methods={"GET"})
     */
    public function getSuccessStudent():JsonResponse
    {
        $bestStudents=$this->studentRepository->getSuccessStudent();

        if($bestStudents==null){
            return new JsonResponse("No Student Has Succeeded!", Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bestStudents, Response::HTTP_OK);

    }

}