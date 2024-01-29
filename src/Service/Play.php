<?php

namespace App\Service;

use App\Entity\Division;
use App\Entity\Game;
use App\Repository\DivisionTeamRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;

class Play
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DivisionTeamRepository $divisionTeamRepository,
        private readonly GameRepository         $gameRepository,
    )
    {
    }

    public function playGame(Game $game)
    {
        $team1Goals = rand(0, 10);
        $team2Goals = rand(0, 10);

        $game->setTeam1Goals($team1Goals);
        $game->setTeam2Goals($team2Goals);
        $game->setPlayed(new \DateTime());

        $this->proceedPoints($game);

        $this->entityManager->flush();

        return $game;
    }

    private function proceedPoints(Game $game):void
    {
        if (str_contains($game->getRound(), 'Round')) {
            $team1 = $game->getTeam1();
            $team2 = $game->getTeam2();

            $team1Division = $this->divisionTeamRepository->findByTeam($team1);
            $team2Division = $this->divisionTeamRepository->findByTeam($team2);

            if ($game->getTeam1Goals() > $game->getTeam2Goals()) {
                $team1Division->addPoints(3);
            } elseif ($game->getTeam1Goals() < $game->getTeam2Goals()) {
                $team2Division->addPoints(3);
            } else {
                $team1Division->addPoints(1);
                $team2Division->addPoints(1);
            }

            $this->entityManager->flush();

            // Update play off schedule
            $this->updatePlayOffSchedule($team1Division->getDivision(), $game);
        }
    }

    private function updatePlayOffSchedule(Division $division, Game $game): void
    {
        $divisionStandings = $this->divisionTeamRepository->getDivisionTopFour($division);
        $playOffGames = $this->gameRepository->findBy(['round' => 'Quarterfinal'], ['id' => 'ASC']);

        $standingIndex = 0;
        foreach ($playOffGames as $playOffGame) {
            if (str_contains($game->getRound(), 'Division A')) {
                $playOffGame->setTeam1($divisionStandings[$standingIndex]->getTeam());
                $this->entityManager->flush();
            } else {
                $playOffGame->setTeam2($divisionStandings[$standingIndex]->getTeam());
            }
            $standingIndex++;
        }
    }
}
