<?php

namespace App\Controller\api\Document;

use App\Application\Model\Response\Work\GetFileResponseModel;
use App\Entity\Material;
use App\Entity\MaterialFiles;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetDocumentController extends AbstractController
{
    #[Route('/api/kit/{kitId}/documents',  name: "get_document_by_kit", methods: ["GET"])]
    public function get_files(
        string $kitId,
        ManagerRegistry $doctrine,
    ): Response {


        // $material = $doctrine->getRepository(Material::class)->find($materialId);

        // if (!$material) {
        //     throw $this->createNotFoundException(
        //         'material not found'
        //     );
        // }

        // $collections = array();

        // $materialFiles = $doctrine->getRepository(MaterialFiles::class)->findBy(["material" => $material->getId()]);

        // foreach ($materialFiles as $item) {
        //     $collections[] = GetFileResponseModel::create($item->getFile());
        // }

        return $this->json([]);
    }
}
