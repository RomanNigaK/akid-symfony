<?php

namespace App\Controller\api\Person;

use App\Application\Model\Request\Person\CreatePersonRequestModel;
use App\Application\Model\Request\Person\UpdatePersonRequestModel;
use App\Entity\Person;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    #[Route('/api/person/{personId}', methods: ['PUT'])]
    public function update_person(
        Request $request,
        ManagerRegistry $doctrine,
        string $personId
    ): Response {
        $entityManager = $doctrine->getManager();

        $person = $entityManager->getRepository(Person::class)->find($personId);

        if (!$person) {
            throw $this->createNotFoundException(
                'person not found'
            );
        }

        $person = UpdatePersonRequestModel::create($request, $person);

        $entityManager->persist($person);

        $entityManager->flush();

        return $this->json(Response::HTTP_OK);
    }
}
