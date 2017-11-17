<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Entity\Competition;
use Endroid\SoccerData\Entity\Team;

interface TeamLoaderInterface
{
    public function loadByName(string $name): Team;
    public function loadByCompetition(Competition $competition): array;
}
