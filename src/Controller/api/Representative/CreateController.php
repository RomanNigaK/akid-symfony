<?php

namespace App\Controller\api\Representative;

use App\Application\Model\Request\ConstructionControl\CreateConstructionControlResponseModel;
use App\Application\Model\Request\Representative\CreateRepresentativeRequestModel;
use App\Application\Model\Request\Representative\CreateRepresentativeResponseModel;
use App\Entity\Kit;
use App\Entity\Person;
use App\Entity\Representative;
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

    #[Route('/api/person/{personId}/representative', methods: ['POST'])]
    public function create_representative(
        Request $request,
        string $personId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $person = $doctrine->getRepository(Person::class)->find($personId);

        if (!$person) return $this->json(["person not found"], 400);

        $requestData = CreateRepresentativeRequestModel::create($request);

        $representative = new Representative($requestData);

        $representative->setPerson($person);

        $entityManager->persist($representative);

        $entityManager->flush();

        $person->setRepresentative($representative);

        $entityManager->persist($person);

        $entityManager->flush();

        $createdRecord = $doctrine->getRepository(Representative::class)->find($representative->getId());

        return $this->json(CreateRepresentativeResponseModel::create($createdRecord));
    }
}
