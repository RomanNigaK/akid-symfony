<?php

namespace App\Controller\api\Work;

use App\Application\Model\Request\Work\CreateWorkRequestModel;
use App\Application\Model\Response\Work\CreateWorkResponseModel;
use App\Entity\Kit;
use App\Entity\Work;
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

    #[Route('/api/kit/{kitId}/work', methods: ['POST'])]
    public function create(
        Request $request,
        string $kitId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) return $this->json(["Kit not found"], 400);

        $reguestData = CreateWorkRequestModel::create($request);

        $work = new Work($reguestData);

        $work->setKit($kit);

        $entityManager->persist($work);

        $entityManager->flush();

        $createdRecord = $doctrine->getRepository(Work::class)->find($work->getId());

        if (!$createdRecord) return $this->json(["Kit not found"], 400);

        return $this->json(CreateWorkResponseModel::create($createdRecord));
    }
}
