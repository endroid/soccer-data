<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Entity;

class Game
{
    public function __construct(
        private readonly string $id,
        private readonly \DateTimeImmutable $date,
        private readonly Team $teamHome,
        private readonly Team $teamAway,
        private readonly Score|null $score
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTeamHome(): Team
    {
        return $this->teamHome;
    }

    public function getTeamAway(): Team
    {
        return $this->teamAway;
    }

    public function getTitle(): string
    {
        return $this->getTeamHome()->getName().' - '.$this->getTeamAway()->getName();
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getDateEnd(): \DateTimeImmutable
    {
        // When the exact time is not known return the day
        if ('00:00' === $this->date->format('H:i')) {
            return $this->date->add(new \DateInterval('P1D'));
        }

        // When the exact time is known return +105 minutes
        return $this->date->add(new \DateInterval('PT105M'));
    }

    public function getScore(): Score|null
    {
        return $this->score;
    }
}
