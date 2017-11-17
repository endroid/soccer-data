<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi;

use Goutte\Client as GoutteClient;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Crawler;

final class Client
{
    private $client;

    public function __construct(GoutteClient $client)
    {
        $this->client = $client;
    }

    public function getCrawler(string $url): Crawler
    {
        $this->client->followRedirects(false);
        $this->client->getCookieJar()->set(new Cookie('BCPermissionLevel', 'PERSONAL'));

        return $this->client->request('GET', $url);
    }

    public function ensureAbsoluteUrl(string $url): string
    {
        if (strpos($url, '/') === 0) {
            $url = 'https://www.vi.nl'.$url;
        }

        return $url;
    }
}
