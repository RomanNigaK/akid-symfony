<?php

namespace App\Controller\api\Work;

use App\Application\Model\Response\Work\CreateWorkResponseModel;
use App\Application\Model\Response\WorkResponseModel;
use App\Entity\Kit;
use App\Entity\Set;
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

    #[Route('/api/kit/{kitId}/works', methods: ['GET'])]
    public function get_works(
        ManagerRegistry $doctrine,
        string $kitId,
    ): Response {

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) {
            throw $this->createNotFoundException(
                'Kit not found'
            );
        }

        $works = $doctrine->getRepository(Work::class)->findBy(["kit" => $kit->getId()]);

        $collections = array();

        foreach ($works as $item) {
            $count = $doctrine->getRepository(WorkMaterials::class)->findBy(["work" => $item]);
            $collections[] = CreateWorkResponseModel::create($item, count($count));
        }

        return $this->json($collections);
    }
}
