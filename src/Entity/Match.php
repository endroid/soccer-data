<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

use DateTime;

class Match
{
    private $id;
    private $teamHome;
    private $teamAway;
    private $date;
    private $scoreHome;
    private $scoreAway;

    public function __construct(string $id, DateTime $date, Team $teamHome, Team $teamAway, int $scoreHome = null, int $scoreAway = null)
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

    public function getDate(): DateTime
    {
        return $this->date;
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
