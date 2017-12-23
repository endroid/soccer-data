<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi\Loader;

use DateTime;
use DateTimeZone;
use Endroid\SoccerData\Entity\Match;
use Endroid\SoccerData\Entity\Team;
use Endroid\SoccerData\Loader\MatchLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Endroid\SoccerData\Vi\Client;
use Symfony\Component\DomCrawler\Crawler;

final class MatchLoader implements MatchLoaderInterface
{
    private $days = [
        'Za' => 'sat',
        'Zo' => 'Sun',
        'Ma' => 'Mon',
        'Di' => 'Tue',
        'Wo' => 'Wed',
        'Do' => 'Thu',
        'Vr' => 'Fri',
    ];

    private $months = [
        'jan' => 'jan',
        'feb' => 'feb',
        'mrt' => 'mar',
        'apr' => 'apr',
        'mei' => 'may',
        'jun' => 'jun',
        'jul' => 'jul',
        'aug' => 'aug',
        'sep' => 'sep',
        'okt' => 'oct',
        'nov' => 'nov',
        'dec' => 'dec',
    ];

    private $client;
    private $teamLoader;
    private $matchesById;

    public function __construct(Client $client, TeamLoaderInterface $teamLoader)
    {
        $this->client = $client;
        $this->teamLoader = $teamLoader;
        $this->matchesById = [];
    }

    public function loadByTeam(Team $team): array
    {
        $contents = $this->client->loadContents($team->getId());
        $crawler = new Crawler($contents);
        $crawler->filter('.c-match-overview')->each(function (Crawler $node) use ($team) {
            $id = $this->client->ensureAbsoluteUrl($node->filter('.c-match-overview__link')->attr('href'));

            $dateString = strtr($node->filter('h3')->html(), $this->days + $this->months);
            $timeString = trim($node->filter('.c-fixture__status')->text());

            if (false === strpos($timeString, ':')) {
                $timeString = '00:00';
            }

            $date = DateTime::createFromFormat('D j M H:i', $dateString.' '.$timeString, new DateTimeZone('Europe/Amsterdam'));

            $teamHome = $this->teamLoader->loadByName(trim($node->filter('.c-fixture__team-name--home')->text()));
            $teamAway = $this->teamLoader->loadByName(trim($node->filter('.c-fixture__team-name--away')->text()));

            $scoreHome = trim($node->filter('.c-fixture__score--home')->text());
            if ('-' === $scoreHome) {
                $scoreHome = null;
            }

            $scoreAway = trim($node->filter('.c-fixture__score--away')->text());
            if ('-' === $scoreAway) {
                $scoreAway = null;
            }

            $match = new Match($id, $date, $teamHome, $teamAway, $scoreHome, $scoreAway);

            $this->addMatch($match);
            $team->addMatch($match);
        });

        return $team->getMatches();
    }

    private function addMatch(Match $match): void
    {
        $this->matchesById[$match->getId()] = $match;
    }
}
