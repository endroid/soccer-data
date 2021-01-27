<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

class Game
{
    private $id;
    private $teamHome;
    private $teamAway;
    private $date;
    private $scoreHome;
    private $scoreAway;

    public function __construct(string $id, \DateTimeImmutable $date, Team $teamHome, Team $teamAway, int $scoreHome = null, int $scoreAway = null)
    {
        $this->id = $id;
        $this->date = $date;
        $this->teamHome = $teamHome;
        $this->teamAway = $teamAway;
        $this->scoreHome = $scoreHome;
        $this->scoreAway = $scoreAway;
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

    public function getScoreHome(): ?int
    {
        return $this->scoreHome;
    }

    public function getScoreAway(): ?int
    {
        return $this->scoreAway;
    }
}
