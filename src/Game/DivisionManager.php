<?php
namespace App\Game;

use App\Entity\Division;
use App\Entity\Game;
use App\Entity\Team;
use App\Repository\DivisionTeamRepository;
use Doctrine\ORM\EntityManagerInterface;

class DivisionManager
{
    const int WIN_POINTS = 3;
    const int DRAW_POINTS = 1;

    public function __construct(
        private readonly DivisionTeamRepository $divisionTeamRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function addPoints(Team $team, int $points): void
    {
        $teamDivision = $this->divisionTeamRepository->findByTeam($team);
        $teamDivision->addPoints($points);


        $this->entityManager->flush();
    }

    /**
     * @TODO: Should take division as a param
     *
     * @return Team[]
     */
    public function getDivisionPlayOffsQualifiers(Game $game): array
    {
        // Since it's a division game, we can get the division from any team
        $teamDivision = $this->divisionTeamRepository->findByTeam($game->getTeam1());

        return $this->divisionTeamRepository->getDivisionTopFour($teamDivision->getDivision());
    }
}
