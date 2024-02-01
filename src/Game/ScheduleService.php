<?php

namespace App\Game;

use App\Entity\Tournament;
use App\Game\ScheduleGenerator\DivisionScheduleGenerator;
use App\Game\ScheduleGenerator\PlayOffScheduleGenerator;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ScheduleService
{
    public function __construct(
        private RoundManager              $roundManager,
        private GameRepository            $gameRepository,
        private DivisionScheduleGenerator $divisionScheduleGenerator,
        private PlayOffScheduleGenerator  $playOffScheduleGenerator,
        private EntityManagerInterface    $entityManager,
    )
    {
    }

    public function generate(Tournament $tournament): array
    {
        $divisions = $tournament->getDivisions();

        $this->divisionScheduleGenerator->generate($divisions);
        $this->playOffScheduleGenerator->generate($divisions);

        $this->entityManager->flush();

        return $this->gameRepository->findBy(['tournament' => $tournament], ['id' => 'ASC']);
    }

    public function updateDivisionPlayOffSchedule(array $teams, string $round): void
    {
        $nextRound = $this->roundManager->getNextRound($round);

        if (!$nextRound) {
            return;
        }

        $playOffGames = $this->gameRepository->findBy(['round' => $nextRound], ['id' => 'ASC']);

        $standingIndex = 0;
        foreach ($playOffGames as $playOffGame) {
            if ($this->roundManager->is($round, RoundManager::DIVISION_ROUND_NAME)) {
                $playOffGame->setTeam1($teams[$standingIndex]->getTeam());
            } else {
                $playOffGame->setTeam2($teams[$standingIndex]->getTeam());
            }
            $standingIndex++;
        }

        $this->entityManager->flush();
    }
}
