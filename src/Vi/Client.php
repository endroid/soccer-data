<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi;

use GuzzleHttp\Psr7\Request;
use Http\Client\Common\Plugin\CookiePlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\Cookie;
use Http\Message\CookieJar;

final class Client
{
    public function loadContents(string $url): string
    {
        $cookieJar = new CookieJar();
        $cookieJar->addCookie(new Cookie('BCPermissionLevel', 'PERSONAL'));
        $cookieJar->addCookie(new Cookie('BC_GDPR', '11111'));
        $cookiePlugin = new CookiePlugin($cookieJar);

        $httpClient = new PluginClient(HttpClientDiscovery::find(), [$cookiePlugin, new RedirectPlugin()]);
        $request = new Request('GET', $url);
        $response = $httpClient->sendRequest($request);

        return $response->getBody()->getContents();
    }

    public function ensureAbsoluteUrl(string $url): string
    {
        if (0 === strpos($url, '/')) {
            $url = 'https://www.vi.nl'.$url;
        }

        return $url;
    }
}
