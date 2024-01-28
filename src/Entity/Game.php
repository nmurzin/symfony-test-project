<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team_1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team_2 = null;

    #[ORM\Column]
    private ?int $team_1_goals = null;

    #[ORM\Column]
    private ?int $team_2_goals = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?Team
    {
        return $this->team_1;
    }

    public function setTeam1(?Team $team_1): static
    {
        $this->team_1 = $team_1;

        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->team_2;
    }

    public function setTeam2(?Team $team_2): static
    {
        $this->team_2 = $team_2;

        return $this;
    }

    public function getе�team1Goals(): ?int
    {
        return $this->team_1_goals;
    }

    public function setе�team1Goals(int $team_1_goals): static
    {
        $this->team_1_goals = $team_1_goals;

        return $this;
    }

    public function getTeam2Goals(): ?int
    {
        return $this->team_2_goals;
    }

    public function setTeam2Goals(int $team_2_goals): static
    {
        $this->team_2_goals = $team_2_goals;

        return $this;
    }
}
