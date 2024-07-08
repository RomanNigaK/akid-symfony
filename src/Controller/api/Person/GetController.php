<?php

namespace App\Controller\api\Person;

use App\Application\Model\Response\Person\CreatePersonResponseModel;
use App\Entity\Kit;
use App\Entity\Person;
use App\Enum\EnumTypePerson;
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

    #[Route('/api/kit/{kitId}/{type}/person', methods: ['GET'])]
    public function get_person(
        ManagerRegistry $doctrine,
        string $kitId,
        EnumTypePerson $type,
    ): Response {

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) {
            throw $this->createNotFoundException(
                'Kit not found'
            );
        }

        $person = $doctrine->getRepository(Person::class)->findOneBy(["kit" => $kit->getId(), "type" => $type]);
        if (!$person)
            return $this->json("");

        return $this->json(CreatePersonResponseModel::create($person));
    }
}
