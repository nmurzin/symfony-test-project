<?php

namespace App\Game;

class RoundManager
{
    const string DIVISION_ROUND_NAME = 'Division';
    const string QUARTERFINAL_ROUND_NAME = 'Quarterfinal';
    const string SEMIFINAL_ROUND_NAME = 'Semifinal';
    const string FINAL_ROUND_NAME = 'Final';

    const array ROUND_ASSOCIATION = [
        '1/1' => 'Final',
        '1/2' => 'Semifinal',
        '1/4' => 'Quarterfinal',
    ];

    public function is(string $round, string $compare): bool
    {
        return $round === $compare || str_contains($round, $compare);
    }

    public function getNextRound(string $round): string|bool
    {
        return match (true) {
            $this->is($round, self::FINAL_ROUND_NAME) => false,
            $this->is($round, self::DIVISION_ROUND_NAME) => self::QUARTERFINAL_ROUND_NAME,
            $this->is($round, self::QUARTERFINAL_ROUND_NAME) => self::SEMIFINAL_ROUND_NAME,
            $this->is($round, self::SEMIFINAL_ROUND_NAME) => self::FINAL_ROUND_NAME,
            default => false,
        };
    }
}
