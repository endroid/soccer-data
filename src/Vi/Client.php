<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

final class Client
{
    public function loadContents(string $url): string
    {
        $cookieJar = new CookieJar();
        $cookieJar->set(new Cookie('googlepersonalization', 'OnaDYWOnj55bgA'));
        $cookieJar->set(new Cookie('eupubconsent', 'BOnaDYWOnj55bAKAZAENAAAAwAAAAA'));
        $cookieJar->set(new Cookie('euconsent', 'BOnaDYXOnj55bAKAZBENCn-AAAAqx7_______9______9uz_Ov_v_f__33e8__9v_l_7_-___u_-3zd4u_1vf99yfm1-7etr3tp_87ues2_Xur__79__3z3_9phP78k89r7337Ew-v-3o8AA'));

        $client = new HttpBrowser(HttpClient::create(), null, $cookieJar);
        $crawler = $client->request('GET', $url);

        return $crawler->html();
    }

    public function ensureAbsoluteUrl(string $url): string
    {
        if (0 === strpos($url, '/')) {
            $url = 'https://www.vi.nl'.$url;
        }

        return $url;
    }
}
