<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Team $team_1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Team $team_2 = null;

    #[ORM\Column]
    private ?int $team_1_goals = 0;

    #[ORM\Column]
    private ?int $team_2_goals = 0;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $played = null;

    #[ORM\Column(length: 255)]
    private ?string $round = null;

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

    public function getTeam1Goals(): ?int
    {
        return $this->team_1_goals;
    }

    public function setTeam1Goals(int $team_1_goals): static
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

    public function getPlayed(): ?\DateTimeInterface
    {
        return $this->played;
    }

    public function setPlayed(?\DateTimeInterface $played): static
    {
        $this->played = $played;

        return $this;
    }

    public function getRound(): ?string
    {
        return $this->round;
    }

    public function setRound(string $round): static
    {
        $this->round = $round;

        return $this;
    }

    public function setTournament(Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }
}
