<?php

namespace App\Controller\api\Template;

use App\Application\Model\Response\Template\GetTemplateResponseModel;
use App\Entity\Template;
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

    #[Route('/api/templates', methods: ['GET'])]
    public function get_templates(
        ManagerRegistry $doctrine,
    ): Response {

        $templates = $doctrine->getRepository(Template::class)->findAll();

        $collections = [];
        foreach ($templates as $item) {
            $collections[] = GetTemplateResponseModel::create($item);
        }


        return $this->json($collections);
    }
}
