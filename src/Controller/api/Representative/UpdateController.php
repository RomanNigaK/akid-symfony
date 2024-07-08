<?php

namespace App\Controller\api\Representative;

use App\Application\Model\Request\Representative\CreateRepresentativeResponseModel;
use App\Application\Model\Request\Representative\UpdateRepresentativeRequestModel;
use App\Entity\Representative;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/representative/{representativeId}', methods: ['PUT'])]
    public function update_representative(
        Request $request,
        ManagerRegistry $doctrine,
        string $representativeId
    ): Response {
        $entityManager = $doctrine->getManager();

        $representative = $entityManager->getRepository(Representative::class)->find($representativeId);

        if (!$representative) {
            throw $this->createNotFoundException(
                'representative not found'
            );
        }

        $representative = UpdateRepresentativeRequestModel::create($request, $representative);

        $entityManager->persist($representative);

        $entityManager->flush();

        $updateRow = $doctrine->getRepository(Representative::class)->find($representativeId);

        return $this->json(CreateRepresentativeResponseModel::create($updateRow));
    }
}
