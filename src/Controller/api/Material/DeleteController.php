<?php

namespace App\Controller\api\Material;

use App\Entity\Material;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/api/material/{materialId}', methods: ['DELETE'])]
    public function delete_work(
        ManagerRegistry $doctrine,
        string $materialId
    ): Response {
        $entityManager = $doctrine->getManager();

        $item = $entityManager->getRepository(Material::class)->find($materialId);

        if (!$item) {
            throw $this->createNotFoundException(
                'Item not found'
            );
        }
        $entityManager->remove($item);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
