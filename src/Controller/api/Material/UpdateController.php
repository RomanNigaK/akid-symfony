<?php

namespace App\Controller\api\Material;

use App\Application\Model\Request\Material\UpdateMaterialRequestModel;
use App\Entity\Material;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/material/{materialId}', methods: ['PUT'])]
    public function update_work(
        Request $request,
        ManagerRegistry $doctrine,
        string $materialId
    ): Response {
        $entityManager = $doctrine->getManager();

        $material = $entityManager->getRepository(Material::class)->find($materialId);

        if (!$material) {
            throw $this->createNotFoundException(
                'Item not found'
            );
        }

        $material = UpdateMaterialRequestModel::create($request, $material);

        $entityManager->persist($material);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
