<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Model\Competition;

interface CompetitionLoaderInterface
{
    public function loadByName(string $name): Competition;
}
