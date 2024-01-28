<?php

namespace App\Controller;

use App\DTO\CreateTeamDTO;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'create_team', methods: ['POST'])]
    public function createTeam(
        #[MapRequestPayload] CreateTeamDTO $createTeamDTO,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $team = new Team();
        $team->setName($createTeamDTO->name);

        $entityManager->persist($team);
        $entityManager->flush();

        return $this->json(
            $team,
            Response::HTTP_CREATED
        );
    }

    #[Route('/team', name: 'get_teams', methods: ['GET'])]
    public function index(
        TeamRepository $teamRepository
    ): JsonResponse
    {
        return $this->json(
            $teamRepository->findAll()
        );
    }
}
