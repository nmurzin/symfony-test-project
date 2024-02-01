<?php

namespace App\Game\ScheduleGenerator;

use App\Entity\Tournament;
use App\Game\GameService;
use App\Game\RoundManager;
use Doctrine\Common\Collections\Collection;

class PlayOffScheduleGenerator implements ScheduleGenerator
{
    public function __construct(
        private readonly GameService $gameService,
    )
    {
    }

    public function generate(Collection $divisions): void
    {
        // Let's assume that divisions are valid (4+ teams);
        $numberOfTeams = $divisions->count() * 4;
        $numberOfRounds = (int) log($numberOfTeams, 2);

        $numberOfGamesInRound = (int) $numberOfTeams / 2;
        for ($i = 1; $i <= $numberOfRounds; $i++) {
            $roundName = RoundManager::ROUND_ASSOCIATION[ '1/' . $numberOfGamesInRound] ?? '1/' . $numberOfGamesInRound;
            $this->createRoundGames($numberOfGamesInRound, $roundName, $divisions->first()->getTournament());
            $numberOfGamesInRound = (int) $numberOfGamesInRound / 2;
        }
    }

    private function createRoundGames(int $count, string $roundName, Tournament $tournament)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->gameService->create(null, null, $tournament, $roundName);
        }
    }
}
