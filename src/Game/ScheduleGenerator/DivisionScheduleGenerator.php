<?php

namespace App\Game\ScheduleGenerator;

use App\Entity\Division;
use App\Game\GameService;
use Doctrine\Common\Collections\Collection;

class DivisionScheduleGenerator implements ScheduleGenerator
{
    public function __construct(
        private readonly GameService $gameService,
    )
    {
    }

    public function generate(Collection $divisions): void
    {
        foreach ($divisions as $division) {
            $this->createDivisionSchedule($division);
        }
    }

    private function createDivisionSchedule(Division $division): void
    {
        $rounds = 1;
        $excludedTeams = [];

        foreach ($division->getTeams() as $divisionTeam) {
            $teamsToPlay = $division->getTeams()->filter(function ($dt) use ($excludedTeams, $divisionTeam) {
                return $dt->getTeam()->getId() !== $divisionTeam->getTeam()->getId() &&
                    !in_array($dt->getTeam()->getId(), $excludedTeams);
            });

            foreach ($teamsToPlay as $teamToPlay) {
                $this->gameService->create($divisionTeam->getTeam(), $teamToPlay->getTeam(), $division->getTournament(), $division->getName() . ' - Round ' . $rounds);
                $rounds++;
            }

            $excludedTeams[] = $divisionTeam->getTeam()->getId();
        }
    }
}
