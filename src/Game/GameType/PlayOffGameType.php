<?php

namespace App\Game\GameType;

use App\Entity\Game;

class PlayOffGameType implements GameType
{
    public function handle(Game $game): void
    {
        // TBD: Play off schedule should be updated here
    }
}
