<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Tests\Vi\Loader;

use Endroid\SoccerData\Sofascore\Loader\TeamLoader;
use PHPUnit\Framework\TestCase;

final class TeamLoaderTest extends TestCase
{
    public function testLoadByTeam(): void
    {
        $teamLoader = new TeamLoader();
        $team = $teamLoader->load('Ajax Amsterdam');

        $this->assertGreaterThan(1, count($team->getGames()));
    }
}
