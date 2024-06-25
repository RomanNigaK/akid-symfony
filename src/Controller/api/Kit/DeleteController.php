<?php

namespace App\Controller\api\Kit;

use App\Entity\Kit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/api/kit/{kitId}', methods: ['DELETE'])]
    public function update(
        Request $request,
        ManagerRegistry $doctrine,
        string $kitId
    ): Response {
        $entityManager = $doctrine->getManager();

        $item = $entityManager->getRepository(Kit::class)->find($kitId);

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
