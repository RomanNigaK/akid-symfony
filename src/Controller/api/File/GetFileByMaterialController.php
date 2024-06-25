<?php

namespace App\Controller\api\File;

use App\Application\Model\Response\Work\GetFileResponseModel;
use App\Entity\Material;
use App\Entity\MaterialFiles;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetFileByMaterialController extends AbstractController
{
    #[Route('/api/material/{materialId}/files',  name: "get_files_by_materialId", methods: ["GET"])]
    public function get_files(
        string $materialId,
        ManagerRegistry $doctrine,
    ): Response {


        $material = $doctrine->getRepository(Material::class)->find($materialId);

        if (!$material) {
            throw $this->createNotFoundException(
                'material not found'
            );
        }

        $collections = array();

        $materialFiles = $doctrine->getRepository(MaterialFiles::class)->findBy(["material" => $material->getId()]);

        foreach ($materialFiles as $item) {
            $collections[] = GetFileResponseModel::create($item->getFile());
        }

        return $this->json($collections);
    }
}
