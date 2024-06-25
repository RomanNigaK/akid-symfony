<?php

namespace App\Controller\api\User;

use App\Application\Model\Request\User\UserRequestModel;
use App\Application\Model\Response\User\UserResponseModel;
use App\Entity\Company;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/registration', methods: ['POST'])]
    public function Create(
        Request $request,
        ManagerRegistry $doctrine,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = $doctrine->getRepository(User::class)->findOneBy(["email" => $request->toArray()["email"]]);

        if ($user) {
            return $this->json(["message" => "A user with this email is registered"], 400);
        }

        $entityManager = $doctrine->getManager();

        $reguestData = UserRequestModel::create($request);

        $user = new User($reguestData);

        $plaintextPassword = $user->getPassword();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $entityManager->persist($user);

        $entityManager->flush();

        $company = new Company();

        $company->addUser($user);

        $entityManager->persist($company);

        $entityManager->flush();

        $createdUser = $doctrine->getRepository(User::class)->find($user->getId());

        return $this->json(["data" => UserResponseModel::create($createdUser)]);
    }
}
