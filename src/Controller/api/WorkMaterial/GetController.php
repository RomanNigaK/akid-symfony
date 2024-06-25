<?php

namespace App\Controller\api\WorkMaterial;

use App\Application\Model\Response\Work\CreateWorkResponseModel;
use App\Entity\Kit;
use App\Entity\Work;
use App\Entity\WorkMaterials;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetController extends AbstractController
{
    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/work/{workId}/materials', methods: ['GET'])]
    public function get_work_materials(
        ManagerRegistry $doctrine,
        string $workId,
    ): Response {


        $work = $doctrine->getRepository(Work::class)->find($workId);

        if (!$work) {
            throw $this->createNotFoundException(
                'work not found'
            );
        }

        $workMaterials = $doctrine->getRepository(WorkMaterials::class)->findBy(["work" => $work]);

        $collections = array();

        foreach ($workMaterials as $item) {

            $collections[] = $item->getMaterial()->getId();
        }

        return $this->json($collections);
    }
}
