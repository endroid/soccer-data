<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Entity\Game;
use Endroid\SoccerData\Entity\Team;

interface GameLoaderInterface
{
    /** @return array<Game> */
    public function loadByTeam(Team $team): array;
}
