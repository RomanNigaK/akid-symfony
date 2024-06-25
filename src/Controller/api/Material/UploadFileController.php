<?php

namespace App\Controller\api\Material;

use App\Application\Model\Request\Material\UpdateMaterialRequestModel;
use App\Entity\File;
use App\Entity\Material;
use App\Entity\MaterialFiles;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadFileController extends AbstractController
{
    #[Route('/api/material/{materialId}/upload-file',  name: "post_file", methods: ["POST"])]
    public function upload_file(
        Request $request,
        FileUploader $fileUploader,
        string $materialId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $uploadedFile = $request->files->get('file');

        $file = $fileUploader->upload($uploadedFile);

        $file = new File($file["saveName"], $file["originalName"]);

        $entityManager->persist($file);

        $entityManager->flush();

        print_r($materialId);

        $material = $doctrine->getRepository(Material::class)->find($materialId);

        if (!$material) {
            throw $this->createNotFoundException(
                'material not found'
            );
        }

        $materialFiles = new MaterialFiles($material, $file);

        $entityManager->persist($materialFiles);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
