<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Tests\Vi\Loader;

use Endroid\SoccerData\Entity\Competition;
use Endroid\SoccerData\Vi\Client;
use Endroid\SoccerData\Vi\Loader\CompetitionLoader;
use Endroid\SoccerData\Vi\Loader\MatchLoader;
use Endroid\SoccerData\Vi\Loader\TeamLoader;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use PHPUnit\Framework\TestCase;

class MatchLoaderTest extends TestCase
{
    public function testLoadByTeam()
    {
        $goutteClient = new GoutteClient();
        $guzzleClient = new GuzzleClient(['timeout' => 90, 'verify' => false]);
        $goutteClient->setClient($guzzleClient);

        $client = new Client($goutteClient);
        $competitionLoader = new CompetitionLoader($client);
        $competition = $competitionLoader->loadByName('Eredivisie');

        $this->assertTrue($competition instanceof Competition);
        $this->assertTrue($competition->getName() === 'Eredivisie');

        $teamLoader = new TeamLoader($client);
        $teams = $teamLoader->loadByCompetition($competition);

        $this->assertGreaterThan(1, count($teams));

        $matchLoader = new MatchLoader($client, $teamLoader);
        $matches = $matchLoader->loadByTeam($teams[0]);

        $this->assertGreaterThan(1, count($matches));
    }
}
