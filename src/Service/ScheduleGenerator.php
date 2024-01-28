<?php

namespace App\Service;

use App\Entity\Division;
use App\Entity\Game;
use App\Entity\Tournament;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class ScheduleGenerator
{
    private const ROUND_ASSOCIATIONS = [
        '1/1' => 'Final',
        '1/2' => 'Semifinal',
        '1/4' => 'Quarterfinal',
    ];

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function generateSchedule(Tournament $tournament)
    {
        $divisions = $tournament->getDivisions();
        foreach ($divisions as $division) {
            $this->createDivisionSchedule($division);
        }

        $this->createPlayOffSchedule($divisions);

        $this->entityManager->flush();
    }

    private function createDivisionSchedule(Division $division)
    {
        $rounds = 1;
        $excludedTeams = [];

        foreach ($division->getTeams() as $divisionTeam) {
            $teamsToPlay = $division->getTeams()->filter(function ($t) use ($excludedTeams, $divisionTeam) {
                return $t->getTeam()->getId() !== $divisionTeam->getTeam()->getId() &&
                    !in_array($t->getTeam()->getId(), $excludedTeams);
            });

            foreach ($teamsToPlay as $teamToPlay) {
                $game = new Game();
                $game->setTeam1($divisionTeam->getTeam());
                $game->setTeam2($teamToPlay->getTeam());
                $game->setTournament($division->getTournament());
                $game->setTeam1Goals(0);
                $game->setTeam2Goals(0);
                $game->setRound($division->getName() . ' - Round ' . $rounds);

                $rounds++;
                $this->entityManager->persist($game);
            }

            $excludedTeams[] = $divisionTeam->getTeam()->getId();
        }
    }

    private function createPlayOffSchedule(Collection $divisions)
    {
        // Let's assume that divisions are valid (4+ teams);
        $numberOfTeams = $divisions->count() * 4;
        $numberOfRounds = (int) log($numberOfTeams, 2);

        $numberOfGamesInRound = (int) $numberOfTeams / 2;
        for ($i = 1; $i <= $numberOfRounds; $i++) {
            $roundName = self::ROUND_ASSOCIATIONS[ '1/' . $numberOfGamesInRound] ?? '1/' . $numberOfGamesInRound;
            $this->createRoundGames($numberOfGamesInRound, $roundName, $divisions->first()->getTournament());
            $numberOfGamesInRound = (int) $numberOfGamesInRound / 2;
        }
    }

    private function createRoundGames(int $count, string $roundName, Tournament $tournament)
    {
        for ($i = 0; $i < $count; $i++) {
            $game = new Game();
            $game->setTeam1(null);
            $game->setTeam2(null);
            $game->setTournament($tournament);
            $game->setTeam1Goals(0);
            $game->setTeam2Goals(0);
            $game->setRound($roundName);

            $this->entityManager->persist($game);
        }
    }
}
