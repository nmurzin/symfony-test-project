<?php

namespace App\Game;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Event\GamePlayedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

readonly class GameService
{
    public function __construct(
        private EntityManagerInterface   $entityManager,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function create(?Team $team1, ?Team $team2, Tournament $tournament, string $round): void
    {
        $game = new Game;
        $game->setTeam1($team1);
        $game->setTeam2($team2);
        $game->setTournament($tournament);
        $game->setRound($round);

        $this->entityManager->persist($game);
    }

    public function play(Game $game, int $team1Score, int $team2Score): Game
    {
        $game->setTeam1Goals($team1Score);
        $game->setTeam2Goals($team2Score);
        $game->setPlayed(new \DateTime());

        $this->entityManager->flush();
        $this->eventDispatcher->dispatch(new GamePlayedEvent($game));

        return $game;
    }
}
