<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Model;

final class Team
{
    /** @var array<Game> */
    private array $games = [];

    public function __construct(
        public readonly string|int $id,
        public readonly string $name
    ) {
    }

    /** @return array<Game> */
    public function getGames(): array
    {
        return $this->games;
    }

    public function addGame(Game $game): void
    {
        $this->games[] = $game;
    }
}
