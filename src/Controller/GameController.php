<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Tournament;
use App\Event\GamePlayedEvent;
use App\Service\Play;
use App\Service\ScheduleGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse
    {
        $team1Goals = rand(0, 10);
        $team2Goals = rand(0, 10);

        $game->setTeam1Goals($team1Goals);
        $game->setTeam2Goals($team2Goals);
        $game->setPlayed(new \DateTime());

        $entityManager->flush();
        $eventDispatcher->dispatch(new GamePlayedEvent($game));

        return $this->json([
            'game' => $game
        ]);
    }
}
