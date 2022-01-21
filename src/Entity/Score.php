<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

class Score
{
    public function __construct(
        private readonly int $scoreHome,
        private readonly int $scoreAway
    ) {
    }

    public function getScoreHome(): ?int
    {
        return $this->scoreHome;
    }

    public function getScoreAway(): ?int
    {
        return $this->scoreAway;
    }
}
