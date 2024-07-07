<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Sofascore\Loader;

use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Endroid\SoccerData\Model\Game;
use Endroid\SoccerData\Model\Team;

final class TeamLoader implements TeamLoaderInterface
{
    /** @var array<Team> */
    private array $teams = [];

    public function load(string $identifier): Team
    {
        if (isset($this->teams[$identifier])) {
            return $this->teams[$identifier];
        }

        $searchUrl = 'https://www.sofascore.com/api/v1/search/all?q='.urlencode($identifier).'&sport=soccer';
        $contents = file_get_contents($searchUrl);
        $searchData = json_decode($contents, true);

        $team = new Team(
            $searchData['results'][0]['entity']['id'],
            $searchData['results'][0]['entity']['shortName']
        );

        $gamesUrl = 'https://www.sofascore.com/api/v1/team/'.$team->id.'/events/next/0';
        $contents = file_get_contents($gamesUrl);
        $gamesData = json_decode($contents, true);

        foreach ($gamesData['events'] as $event) {
            $game = new Game(
                $event['id'],
                \DateTimeImmutable::createFromFormat('U', (string) $event['startTimestamp']),
                new Team($event['homeTeam']['id'], $event['homeTeam']['shortName']),
                new Team($event['awayTeam']['id'], $event['awayTeam']['shortName']),
                null
            );
            $team->addGame($game);
        }

        return $team;
    }
}
