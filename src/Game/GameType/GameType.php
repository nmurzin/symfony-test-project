<?php
namespace App\Game\GameType;

use App\Entity\Game;

interface GameType
{
    public function handle(Game $game): void;
}
