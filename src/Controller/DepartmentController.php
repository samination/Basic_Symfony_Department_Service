<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{


        private DepartmentRepository $departmentRepository;
        private StudentRepository $studentRepository;

    public function __construct(DepartmentRepository $departmentRepository,StudentRepository $studentRepository)
    {
        $this->departmentRepository = $departmentRepository;
        $this->studentRepository= $studentRepository;
    }

       /* return $this->render('department/index.html.twig', [
            'controller_name' => 'DepartmentController',
        ]);*/

    public function addDepartment(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $DepartmentName = $data['DepartmentName'];
        $DepartmentId = $data['DepartmentId'];
        $Address = $data['Address'];

        if (empty($DepartmentName) || empty($DepartmentId) || empty($Address) ) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->departmentRepository->saveDepartment($DepartmentName,$DepartmentId,$Address);

        return new JsonResponse(['status' => 'Department created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("api/department/{id}/Students", name="assignStudent", methods={"POST"})
     */
    public function assignStudent($id,Request $request): JsonResponse
    {
        $department = $this->departmentRepository->find($id);
        if($department==null){
            return new JsonResponse("Department not Found!", Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $studentId = $data['studentId'];
        if (empty($studentId))
        {
            return new JsonResponse("Please Provide a valid studentId!", Response::HTTP_BAD_REQUEST);
        }
     $this->departmentRepository->assignStudent($id,$studentId,$this->studentRepository);

        return new JsonResponse("Student Assign", Response::HTTP_CREATED);
    }

}
