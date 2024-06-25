<?php

namespace App\Controller\api\Work;

use App\Entity\Work;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('/api/work/{workId}', methods: ['DELETE'])]
    public function delete_work(
        ManagerRegistry $doctrine,
        string $workId
    ): Response {
        $entityManager = $doctrine->getManager();

        $item = $entityManager->getRepository(Work::class)->find($workId);

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
