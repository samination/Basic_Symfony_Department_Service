<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AuthController extends AbstractController
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function Register(Request $request,UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $email = $data['username'];
        $password = $data['password'];


        if (empty($password) || empty($email) ) {
            return new JsonResponse(['status' => 'Please provide a valid username and password'], Response::HTTP_BAD_REQUEST);
        }
        $user=new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword(
            $user,
            $password
        ));
        $user->setRoles(["ROLE_USER"]);

        $this->userRepository->add($user,true);

        return new JsonResponse(['status' => 'Successfully Registered!'], Response::HTTP_CREATED);
    }

}