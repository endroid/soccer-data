<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Model\Game;
use Endroid\SoccerData\Model\Team;

interface GameLoaderInterface
{
    /** @return array<Game> */
    public function loadByTeam(Team $team): array;
}
