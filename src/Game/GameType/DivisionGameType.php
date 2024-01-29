<?php

namespace App\Game\GameType;

use App\Entity\Game;
use App\Game\DivisionManager;
use App\Game\Schedule;

class DivisionGameType implements GameType
{
    public function __construct(
        private readonly DivisionManager $divisionManager,
        private readonly Schedule        $schedule,
    )
    {
    }

    public function handle(Game $game): void
    {
        $this->updateDivisionPoints($game);
        $this->updatePlayOffSchedule($game);
    }

    private function updateDivisionPoints(Game $game): void
    {
        if ($game->getTeam1Goals() > $game->getTeam2Goals()) {
            $this->divisionManager->addPoints($game->getTeam1(), DivisionManager::WIN_POINTS);
        } elseif ($game->getTeam1Goals() < $game->getTeam2Goals()) {
            $this->divisionManager->addPoints($game->getTeam2(), DivisionManager::WIN_POINTS);
        } else {
            $this->divisionManager->addPoints($game->getTeam1(), DivisionManager::DRAW_POINTS);
            $this->divisionManager->addPoints($game->getTeam2(), DivisionManager::DRAW_POINTS);
        }
    }

    private function updatePlayOffSchedule($game): void
    {
        $divisionStandings = $this->divisionManager->getDivisionPlayOffsQualifiers($game);
        $this->schedule->updateDivisionPlayOffSchedule($divisionStandings, $game->getRound());
    }
}
