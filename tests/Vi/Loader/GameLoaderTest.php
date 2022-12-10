<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Tests\Vi\Loader;

use Endroid\SoccerData\Model\Competition;
use Endroid\SoccerData\Vi\Client;
use Endroid\SoccerData\Vi\Loader\CompetitionLoader;
use Endroid\SoccerData\Vi\Loader\GameLoader;
use Endroid\SoccerData\Vi\Loader\TeamLoader;
use PHPUnit\Framework\TestCase;

class GameLoaderTest extends TestCase
{
    public function testLoadByTeam(): void
    {
        $client = new Client();
        $competitionLoader = new CompetitionLoader($client);
        $competition = $competitionLoader->loadByName('Eredivisie');

        $this->assertTrue($competition instanceof Competition);
        $this->assertTrue('Eredivisie' === $competition->name);

        $teamLoader = new TeamLoader($client);
        $teams = $teamLoader->loadByCompetition($competition);

        $this->assertGreaterThan(1, count($teams));

        $gameLoader = new GameLoader($client, $teamLoader);
        $games = $gameLoader->loadByTeam(current($teams));

        $this->assertGreaterThan(1, count($games));
    }
}
