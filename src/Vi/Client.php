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
        $cookieJar->addCookie(new Cookie('googlepersonalization', 'OnaDYWOnj55bgA'));
        $cookieJar->addCookie(new Cookie('eupubconsent', 'BOnaDYWOnj55bAKAZAENAAAAwAAAAA'));
        $cookieJar->addCookie(new Cookie('euconsent', 'BOnaDYXOnj55bAKAZBENCn-AAAAqx7_______9______9uz_Ov_v_f__33e8__9v_l_7_-___u_-3zd4u_1vf99yfm1-7etr3tp_87ues2_Xur__79__3z3_9phP78k89r7337Ew-v-3o8AA'));
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
