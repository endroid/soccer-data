<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi\Loader;

use Endroid\SoccerData\Entity\Competition;
use Endroid\SoccerData\Entity\Team;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Endroid\SoccerData\Vi\Client;
use Symfony\Component\DomCrawler\Crawler;

final class TeamLoader implements TeamLoaderInterface
{
    private $client;

    /** @var Team[] */
    private $teamsByName;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->teamsByName = [];
    }

    public function loadByName(string $name): Team
    {
        if (isset($this->teamsByName[$name])) {
            return $this->teamsByName[$name];
        }

        return new Team('ID', 'Team name');
    }

    public function loadByCompetition(Competition $competition): array
    {
        $contents = $this->client->loadContents($competition->getId());
        $crawler = new Crawler($contents);
        $crawler->filter('.c-stats-table__body .o-table__row')->each(function (Crawler $node) use ($competition) {
            $name = $node->filter('.o-table__cell:nth-child(3)')->text();
            $url = $this->client->ensureAbsoluteUrl(strval($node->attr('href')));
            $team = new Team($url, $name);
            $this->addTeam($team);
            $competition->addTeam($team);
        });

        return $competition->getTeams();
    }

    private function addTeam(Team $team): void
    {
        $this->teamsByName[$team->getName()] = $team;
    }
}
