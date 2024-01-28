<?php
namespace App\Service;

use App\Entity\Game;
use App\Repository\DivisionTeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class Play
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DivisionTeamRepository $divisionTeamRepository,
    )
    {
    }

    public function playGame(Game $game)
    {
        $team1 = $game->getTeam1();
        $team2 = $game->getTeam2();

        $team1Goals = rand(0, 10);
        $team2Goals = rand(0, 10);

        $game->setTeam1Goals($team1Goals);
        $game->setTeam2Goals($team2Goals);
        $game->setPlayed(new \DateTime());

        $team1Division = $this->divisionTeamRepository->findByTeam($team1);
        $team2Division = $this->divisionTeamRepository->findByTeam($team2);

        if ($team1Goals > $team2Goals) {
            $team1Division->addPoints(3);
        } elseif ($team1Goals < $team2Goals) {
            $team2Division->addPoints(3);
        } else {
            $team1Division->addPoints(1);
            $team2Division->addPoints(1);
        }

        $this->entityManager->flush();

        return $game;
    }
}
