<?php

namespace App\Controller\api\ConstructionControl;

use App\Application\Model\Request\ConstructionControl\CreateConstructionControlRequestModel;
use App\Application\Model\Response\ConstructionControl\CreateConstructionControlResponseModel;
use App\Entity\ConstructionControl;
use App\Entity\Person;
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

    #[Route('/api/person/{personId}/construction-control', methods: ['POST'])]
    public function create_constructionControl(
        Request $request,
        string $personId,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $person = $doctrine->getRepository(Person::class)->find($personId);

        if (!$person) return $this->json(["person not found"], 400);

        $requestData = CreateConstructionControlRequestModel::create($request);
        //dd($requestData);

        $constructioncontrol = new ConstructionControl($requestData);

        $constructioncontrol->setPerson($person);

        $entityManager->persist($constructioncontrol);

        $entityManager->flush();

        $person->setConstructioncontrol($constructioncontrol);

        $entityManager->persist($person);

        $entityManager->flush();

        $createdRecord = $doctrine->getRepository(ConstructionControl::class)->find($constructioncontrol->getId());

        return $this->json(CreateConstructionControlResponseModel::create($createdRecord));
    }
}
