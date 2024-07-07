<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Model;

final class Game
{
    public function __construct(
        public readonly string|int $id,
        public readonly \DateTimeImmutable $date,
        public readonly Team $teamHome,
        public readonly Team $teamAway,
        public readonly Score|null $score
    ) {
    }

    public function getTitle(): string
    {
        return $this->teamHome->name.' - '.$this->teamAway->name;
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
}
