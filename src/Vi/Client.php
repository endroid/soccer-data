<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Vi;

final class Client
{
    public function loadContents(string $url): string
    {
        $handle = curl_init($url);

        if (!$handle) {
            throw new \Exception('Could not initialize cURL');
        }

        $cookies = [
            'googlepersonalization=OnaDYWOnj55bgA',
            'eupubconsent=BOnaDYWOnj55bAKAZAENAAAAwAAAAA',
            'euconsent=BOnaDYXOnj55bAKAZBENCn-AAAAqx7_______9______9uz_Ov_v_f__33e8__9v_l_7_-___u_-3zd4u_1vf99yfm1-7etr3tp_87ues2_Xur__79__3z3_9phP78k89r7337Ew-v-3o8AA',
        ];

        curl_setopt($handle, CURLOPT_COOKIE, implode('; ', $cookies));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($handle);
        curl_close($handle);

        if (!is_string($contents)) {
            throw new \Exception('Could not load data from URL');
        }

        return $contents;
    }

    public function ensureAbsoluteUrl(string $url): string
    {
        if (0 === strpos($url, '/')) {
            $url = 'https://www.vi.nl'.$url;
        }

        return $url;
    }
}
