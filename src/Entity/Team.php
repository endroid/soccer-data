<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\SoccerData\Entity;

class Team
{
    private $id;
    private $name;
    private $matches;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->matches = [];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMatches(): array
    {
        return $this->matches;
    }

    public function addMatch(Match $match): void
    {
        $this->matches[] = $match;
    }
}
