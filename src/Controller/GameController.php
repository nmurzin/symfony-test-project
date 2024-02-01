<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Tournament;
use App\Game\GameService;
use App\Game\ScheduleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/create_schedule/{id}', name: 'create_schedule', methods: ['POST'])]
    public function createSchedule(
        Tournament      $tournament,
        ScheduleService $schedule,
    ): JsonResponse
    {
        return $this->json([
            'games' => $schedule->generate($tournament),
        ]);
    }

    #[Route('/play_game/{id}', name: 'play_game', methods: ['POST'])]
    public function playGame(
        Game $game,
        GameService $gameService,
    ): JsonResponse
    {
        return $this->json([
            'game' => $gameService->play($game, rand(0, 10), rand(0, 10)),
        ]);
    }
}
