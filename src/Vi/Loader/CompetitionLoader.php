<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Vi\Loader;

use Endroid\SoccerData\Exception\CompetitionNotFoundException;
use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Model\Competition;
use Endroid\SoccerData\Vi\Client;
use Symfony\Component\DomCrawler\Crawler;

final class CompetitionLoader implements CompetitionLoaderInterface
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function loadByName(string $name): Competition
    {
        $url = 'https://www.vi.nl/competities';

        $contents = $this->client->loadContents($url);
        $crawler = new Crawler($contents);
        $link = $crawler->selectLink($name);

        if (0 === $link->count()) {
            throw new CompetitionNotFoundException(sprintf('Competition with name "%s" not found', $name));
        }

        $id = $this->client->ensureAbsoluteUrl(strval($link->attr('href')));
        $name = $link->text();

        return new Competition($id, $name);
    }
}
