<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Vi\Loader;

use Endroid\SoccerData\Loader\GameLoaderInterface;
use Endroid\SoccerData\Loader\TeamLoaderInterface;
use Endroid\SoccerData\Model\Game;
use Endroid\SoccerData\Model\Score;
use Endroid\SoccerData\Model\Team;
use Endroid\SoccerData\Vi\Client;
use Symfony\Component\DomCrawler\Crawler;

final class GameLoader implements GameLoaderInterface
{
    /** @var array<string, string> */
    private const DAYS = [
        'Za' => 'sat',
        'Zo' => 'Sun',
        'Ma' => 'Mon',
        'Di' => 'Tue',
        'Wo' => 'Wed',
        'Do' => 'Thu',
        'Vr' => 'Fri',
    ];

    /** @var array<string, string> */
    private const MONTHS = [
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

    public function __construct(
        private readonly Client $client,
        private readonly TeamLoaderInterface $teamLoader
    ) {
    }

    /** @return array<Game> */
    public function loadByTeam(Team $team): array
    {
        $contents = $this->client->loadContents($team->id);
        $crawler = new Crawler($contents);
        $crawler->filter('.c-match-overview')->each(function (Crawler $node) use ($team) {
            $id = $this->client->ensureAbsoluteUrl(strval($node->filter('.c-match-overview__link')->attr('href')));

            $dateString = strtr($node->filter('h3')->html(), self::DAYS + self::MONTHS);
            $timeString = trim($node->filter('.c-fixture__status')->text());

            if (!str_contains($timeString, ':')) {
                $timeString = '00:00';
            }

            $date = \DateTimeImmutable::createFromFormat('D j M H:i', trim($dateString, '.').' '.$timeString, new \DateTimeZone('Europe/Amsterdam'));

            if (!$date instanceof \DateTimeImmutable) {
                throw new \Exception('Invalid game date');
            }

            $teamHome = $this->teamLoader->loadByName(trim($node->filter('.c-fixture__team-name--home')->text()));
            $teamAway = $this->teamLoader->loadByName(trim($node->filter('.c-fixture__team-name--away')->text()));

            $score = null;
            $scoreHomeNode = $node->filter('.c-fixture__score--home');
            $scoreAwayNode = $node->filter('.c-fixture__score--away');
            if (1 === $scoreHomeNode->count() && 1 === $scoreAwayNode->count()) {
                $score = new Score(intval(trim($scoreHomeNode->text())), intval(trim($scoreAwayNode->text())));
            }

            $game = new Game($id, $date, $teamHome, $teamAway, $score);

            $team->addGame($game);
        });

        return $team->getGames();
    }
}
