<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Model;

final class Competition
{
    /** @var array<string, Team> */
    private array $teamsByName = [];

    public function __construct(
        public string $id,
        public string $name
    ) {
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
        $this->teamsByName[$team->name] = $team;
    }
}
