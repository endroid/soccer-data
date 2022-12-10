<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Model;

final class Score
{
    public function __construct(
        public int $scoreHome,
        public int $scoreAway
    ) {
    }
}
