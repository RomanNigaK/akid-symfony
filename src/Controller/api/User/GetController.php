<?php

namespace App\Controller\api\User;

use App\Application\Model\Response\User\UserResponseModel;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetController extends AbstractController
{
    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/login', methods: ['POST'])]
    public function signin()
    {
    }


    #[Route('/api/profile', methods: ['GET'])]
    public function profile(
        ManagerRegistry $doctrine
    ): Response {

        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        $user = $doctrine->getRepository(User::class)->findOneBy(["email" => $decodedJwtToken["email"]]);

        return $this->json(UserResponseModel::create($user));
    }
}
