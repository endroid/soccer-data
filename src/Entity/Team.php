<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

class Team
{
    private $id;
    private $name;

    /** @var array<Game> */
    private $games;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->games = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
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
