<?php

namespace App\Entity;

use App\Repository\DivisionTeamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DivisionTeamRepository::class)]
class DivisionTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teams')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Division $division = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\Column]
    private ?int $points = 0;

    public function __construct()
    {
        $this->points = 0;
    }
}
