<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

class Competition
{
    private $id;
    private $name;

    /** @var array<string, Team> */
    private $teamsByName;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->teamsByName = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeamByName(string $name): Team
    {
        return $this->teamsByName[$name];
    }

    /** @return array<Team> */
    public function getTeams(): array
    {
        return $this->teamsByName;
    }

    public function addTeam(Team $team): void
    {
        $this->teamsByName[$team->getName()] = $team;
    }
}
