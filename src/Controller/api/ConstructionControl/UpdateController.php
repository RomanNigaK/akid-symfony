<?php

namespace App\Controller\api\ConstructionControl;

use App\Application\Model\Response\ConstructionControl\CreateConstructionControlResponseModel;
use App\Application\Model\Request\ConstructionControl\UpdateConstructioncontroleRequestModel;
use App\Entity\ConstructionControl;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/construction-control/{constructionControlId}', methods: ['PUT'])]
    public function update_representative(
        Request $request,
        ManagerRegistry $doctrine,
        string $constructionControlId
    ): Response {
        $entityManager = $doctrine->getManager();

        $constructionControl = $entityManager->getRepository(ConstructionControl::class)->find($constructionControlId);

        if (!$constructionControl) {
            throw $this->createNotFoundException(
                'constructionControl not found'
            );
        }

        $constructionControl = UpdateConstructioncontroleRequestModel::create($request, $constructionControl);

        $entityManager->persist($constructionControl);

        $entityManager->flush();

        $updateRow = $doctrine->getRepository(ConstructionControl::class)->find($constructionControlId);

        return $this->json(CreateConstructionControlResponseModel::create($updateRow));
    }
}
