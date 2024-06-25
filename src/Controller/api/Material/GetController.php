<?php

namespace App\Controller\api\Material;

use App\Application\Model\Response\Material\CreateMaterialResponseModel;
use App\Application\Model\Response\Work\GetFileResponseModel;
use App\Entity\File;
use App\Entity\Kit;
use App\Entity\Material;
use App\Entity\MaterialFiles;
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

    #[Route('/api/kit/{kitId}/materials', methods: ['GET'])]
    public function get_materials(
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

        $collections = array();

        foreach ($materials as $item) {

            $materialFiles = $doctrine->getRepository(MaterialFiles::class)->findBy(["material" => $item->getId()]);

            $collectionsfiles = array();

            foreach ($materialFiles as $item2) {
                $collectionsfiles[] = GetFileResponseModel::create($item2->getFile());
            }
            $collections[] = CreateMaterialResponseModel::create($item, $collectionsfiles);
        }

        return $this->json($collections);
    }
}
