<?php

namespace App\Controller\api\Material;

use App\Application\Model\Request\Material\CreateMaterialRequestModel;
use App\Application\Model\Response\Material\CreateMaterialResponseModel;
use App\Entity\Kit;
use App\Entity\Material;
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
    #[Route('/api/kit/{kitId}/material', methods: ['POST'])]
    public function Create(
        Request $request,
        string $kitId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        $user = $doctrine->getRepository(User::class)->findOneBy(["email" => $decodedJwtToken["email"]]);

        if (!$user) {
            return $this->json(["User not found"], 400);
        }

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) return $this->json(["Kit not found"], 400);

        $reguestData = CreateMaterialRequestModel::create($request);

        $material = new Material($reguestData);

        $material->setKit($kit);

        $entityManager->persist($material);

        $entityManager->flush();

        $createdRecord = $doctrine->getRepository(Material::class)->find($material->getId());

        return $this->json(CreateMaterialResponseModel::create($createdRecord));
    }
}
