<?php

declare(strict_types=1);

namespace Endroid\SoccerData\Model;

final class Score
{
    public function __construct(
        public readonly int $scoreHome,
        public readonly int $scoreAway
    ) {
    }
}
