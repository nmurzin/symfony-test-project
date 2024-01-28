<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Tournament;
use App\Service\Play;
use App\Service\ScheduleGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/create_schedule/{id}', name: 'create_schedule', methods: ['POST'])]
    public function createSchedule(
        Tournament $tournament,
        ScheduleGenerator $scheduleGenerator
    ): JsonResponse
    {
        $scheduleGenerator->generateSchedule($tournament);

        return $this->json([
            'success' => true
        ]);
    }

    #[Route('/play_game/{id}', name: 'play_game', methods: ['POST'])]
    public function playGame(
        Game $game,
        Play $playService
    ): JsonResponse
    {
        $played = $playService->playGame($game);

        return $this->json([
            'game' => $played
        ]);
    }
}
