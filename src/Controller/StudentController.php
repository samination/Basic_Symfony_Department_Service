<?php
namespace App\Controller;

use App\Dto\StudentResponseDto;
use App\Repository\StudentRepository;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StudentController extends AbstractController
{
    private StudentRepository $studentRepository;
    private StudentService $studentService;
    private SerializerInterface $serializer;

    public function __construct(StudentRepository $studentRepository,StudentService $studentService, SerializerInterface $serializer)
    {
        $this->studentRepository = $studentRepository;
        $this->studentService = $studentService;
        $this->serializer= $serializer;
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
        $studentsDto = $this->studentService->getAllStudents();


        $dto = $this->serializer->serialize($studentsDto, 'json');

        if(empty($dto)){
            return new JsonResponse("Student not Found!", Response::HTTP_NOT_FOUND);
        }



        return new JsonResponse($dto,Response::HTTP_OK,[],true);
    }

    /**
     * @Route("/students/{name}", name="get_one_student", methods={"GET"})
     */
    public function get($name): JsonResponse
    {
        $studentDto =$this->studentService->getStudentByName($name);

        $dto = $this->serializer->serialize($studentDto, 'json');

            if(empty($studentDto)){
                return new JsonResponse("Student not Found!", Response::HTTP_NOT_FOUND);
            }



        return new JsonResponse($dto,Response::HTTP_OK,[],true);
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