<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Vi\Loader;

use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Endroid\SoccerData\Model\Competition;
use Endroid\SoccerData\Model\Team;
use Endroid\SoccerData\Vi\Client;
use Symfony\Component\DomCrawler\Crawler;

final class TeamLoader implements TeamLoaderInterface
{
    /** @var array<Team> */
    private array $teamsByName = [];

    public function __construct(
        private Client $client
    ) {
    }

    public function loadByName(string $name): Team
    {
        if (isset($this->teamsByName[$name])) {
            return $this->teamsByName[$name];
        }

        return new Team('ID', 'Team name');
    }

    /** @return array<Team> */
    public function loadByCompetition(Competition $competition): array
    {
        $contents = $this->client->loadContents($competition->id);
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
        $this->teamsByName[$team->name] = $team;
    }
}
