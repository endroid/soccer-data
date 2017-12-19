<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi\Loader;

use Endroid\SoccerData\Entity\Competition;
use Endroid\SoccerData\Exception\CompetitionNotFoundException;
use Endroid\SoccerData\Loader\CompetitionLoaderInterface;
use Endroid\SoccerData\Vi\Client;

final class CompetitionLoader implements CompetitionLoaderInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function loadByName(string $name): Competition
    {
        $url = 'https://www.vi.nl/competities';

        $crawler = $this->client->getCrawler($url);
        $link = $crawler->selectLink($name);

        if (0 === $link->count()) {
            throw new CompetitionNotFoundException(sprintf('Competition with name "%s" not found', $name));
        }

        $id = $this->client->ensureAbsoluteUrl($link->attr('href'));
        $name = $link->text();

        $competition = new Competition($id, $name);

        return $competition;
    }
}
