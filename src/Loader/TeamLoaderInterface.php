<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Loader;

use Endroid\SoccerData\Model\Team;

interface TeamLoaderInterface
{
    public function load(string $identifier): Team;
}
