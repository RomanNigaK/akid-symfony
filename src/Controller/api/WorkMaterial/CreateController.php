<?php

namespace App\Controller\api\WorkMaterial;

use App\Application\Model\Request\Work\CreateWorkRequestModel;
use App\Application\Model\Request\WorkMaterials\CreateWorkMaterialsRequestModel;
use App\Application\Model\Response\Work\CreateWorkResponseModel;
use App\Entity\Kit;
use App\Entity\Material;
use App\Entity\Work;
use App\Entity\WorkMaterials;
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

    #[Route('/api/work/{workId}/materials', methods: ['POST'])]
    public function create(
        Request $request,
        string $workId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $work = $doctrine->getRepository(Work::class)->find($workId);

        if (!$work) return $this->json(["Kit not found"], 400);

        $reguestData = CreateWorkMaterialsRequestModel::create($request);

        $workMaterials = $doctrine->getRepository(WorkMaterials::class)->findBy(["work" => $work]);



        foreach ($workMaterials as $item) {
            $entityManager->remove($item);
            $entityManager->flush();
        }

        foreach ($reguestData->getIds() as $item) {

            $material = $doctrine->getRepository(Material::class)->find($item);
            if ($material) {

                $materialWork = new WorkMaterials($work, $material);

                $entityManager->persist($materialWork);

                $entityManager->flush();
            }
        }

        return $this->json(Response::HTTP_CREATED);
    }
}
