<?php

namespace App\Controller\api\Kit;

use App\Application\Model\Response\Kit\CreateKitResponseModel;
use App\Entity\Kit;
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

    #[Route('/api/kits', methods: ['GET'])]
    public function getAll(
        ManagerRegistry $doctrine,
    ): Response {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        $user = $doctrine->getRepository(User::class)->findOneBy(["email" => $decodedJwtToken["email"]]);

        $sets = $doctrine->getRepository(Kit::class)->findBy(["user" => $user->getId()]);

        $collections = array();

        foreach ($sets as $item) {

            $collections[] = CreateKitResponseModel::create($item);
        }

        return $this->json($collections);
    }

    #[Route('/api/kit/{kitId}', methods: ['GET'])]
    public function getOne(
        ManagerRegistry $doctrine,
        string $kitId,
    ): Response {

        $set = $doctrine->getRepository(Kit::class)->find($kitId);

        return $this->json(CreateKitResponseModel::create($set));
    }
}
