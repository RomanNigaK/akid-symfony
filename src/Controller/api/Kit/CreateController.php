<?php

namespace App\Controller\api\Kit;

use App\Application\Model\Request\Kit\CreateKitRequestModel;
use App\Application\Model\Response\Kit\CreateKitResponseModel;
use App\Entity\Kit;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateController extends AbstractController
{
    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/set', methods: ['POST'])]
    public function Create(
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        $user = $doctrine->getRepository(User::class)->findOneBy(["email" => $decodedJwtToken["email"]]);

        if (!$user) {
            return $this->json(["User not found"], 400);
        }

        $entityManager = $doctrine->getManager();

        $reguestData = CreateKitRequestModel::create($request);

        $kit = new Kit($reguestData);

        $kit->setUser($user);

        $entityManager->persist($kit);

        $entityManager->flush();

        $createdSet = $doctrine->getRepository(Kit::class)->find($kit->getId());

        return $this->json(["data" => CreateKitResponseModel::create($createdSet)]);
    }
}
