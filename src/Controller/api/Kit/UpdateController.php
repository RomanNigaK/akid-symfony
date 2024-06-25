<?php

namespace App\Controller\api\Kit;

use App\Application\Model\Request\Kit\UpdateKitRequestModel;
use App\Entity\Kit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/kit/{kitId}', methods: ['PUT'])]
    public function update(
        Request $request,
        ManagerRegistry $doctrine,
        string $kitId
    ): Response {
        $entityManager = $doctrine->getManager();

        $kit = $entityManager->getRepository(Kit::class)->find($kitId);

        if (!$kit) {
            throw $this->createNotFoundException(
                'Item not found'
            );
        }

        UpdateKitRequestModel::create($request, $kit);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
