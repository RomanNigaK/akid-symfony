<?php

namespace App\Controller\api\Work;

use App\Application\Model\Request\Work\UpdateWorkRequestModel;
use App\Entity\Work;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/work/{workId}', methods: ['PUT'])]
    public function update_work(
        Request $request,
        ManagerRegistry $doctrine,
        string $workId
    ): Response {
        $entityManager = $doctrine->getManager();

        $work = $entityManager->getRepository(Work::class)->find($workId);

        if (!$work) {
            throw $this->createNotFoundException(
                'Item not found'
            );
        }

        $work = UpdateWorkRequestModel::create($request, $work);

        $entityManager->persist($work);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
