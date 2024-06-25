<?php

namespace App\Controller\api\Material;

use App\Entity\Kit;
use App\Entity\Material;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetCountController extends AbstractController
{
    public function __construct(
        TokenStorageInterface $tokenStorageInterface,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/kit/{kitId}/materials/count', methods: ['GET'])]
    public function get_amount_materials(
        ManagerRegistry $doctrine,
        string $kitId,
    ): Response {

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) {
            throw $this->createNotFoundException(
                'Kit not found'
            );
        }

        $materials = $doctrine->getRepository(Material::class)->findBy(["kit" => $kit->getId()]);

        return $this->json(["count" => count($materials)]);
    }
}
