<?php

namespace App\Controller\api\Person;

use App\Application\Model\Request\Person\CreatePersonRequestModel;
use App\Application\Model\Response\Person\CreatePersonResponseModel;
use App\Entity\Kit;
use App\Entity\Person;
use App\Enum\EnumTypePerson;
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

    #[Route('/api/kit/{kitId}/{type}/person', methods: ['POST'])]
    public function create_person(
        Request $request,
        string $kitId,
        EnumTypePerson $type,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $kit = $doctrine->getRepository(Kit::class)->find($kitId);

        if (!$kit) return $this->json(["Kit not found"], 400);

        $requestData = CreatePersonRequestModel::create($request);

        $person = new Person($requestData);

        $person->setType($type);

        $person->setKit($kit);

        $entityManager->persist($person);

        $entityManager->flush();

        $createdPerson = $doctrine->getRepository(Person::class)->find($person->getId());


        return $this->json(CreatePersonResponseModel::create($createdPerson));
    }
}
