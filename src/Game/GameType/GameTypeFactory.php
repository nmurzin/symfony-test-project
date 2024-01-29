<?php

namespace App\Game\GameType;

use App\Game\DivisionManager;
use App\Game\RoundManager;
use App\Game\Schedule;

class GameTypeFactory
{
    public function __construct(
        private readonly DivisionManager $divisionManager,
        private readonly RoundManager    $roundManager,
        private readonly Schedule        $schedule,
    )
    {
    }

    public function getGameType(string $round)
    {
        if ($this->roundManager->is($round, RoundManager::DIVISION_ROUND_NAME)) {
            return new DivisionGameType(
                $this->divisionManager,
                $this->schedule,
            );
        }

        return new PlayOffGameType();
    }
}
