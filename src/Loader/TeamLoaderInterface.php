<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Model\Competition;
use Endroid\SoccerData\Model\Team;

interface TeamLoaderInterface
{
    public function loadByName(string $name): Team;

    /** @return array<Team> */
    public function loadByCompetition(Competition $competition): array;
}
