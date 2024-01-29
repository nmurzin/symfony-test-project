<?php

namespace App\Game;

use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;

class Schedule
{
    public function __construct(
        private readonly RoundManager $roundManager,
        private readonly GameRepository $gameRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function generate() {
    }

    public function updatePlayOffSchedule(array $teams, string $round): void
    {
        $nextRound = $this->roundManager->getNextRound($round);
        if (!$nextRound) {
            return;
        }

        $playOffGames = $this->gameRepository->findBy(['round' => $nextRound], ['id' => 'ASC']);

        $standingIndex = 0;
        foreach ($playOffGames as $playOffGame) {
            if ($this->roundManager->isFirstDivision($round)) {
                $playOffGame->setTeam1($teams[$standingIndex]->getTeam());
            } else {
                $playOffGame->setTeam2($teams[$standingIndex]->getTeam());
            }
            $standingIndex++;
        }

        $this->entityManager->flush();
    }
}
