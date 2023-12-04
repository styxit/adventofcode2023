<?php

namespace Puzzles\Day4;

use Illuminate\Support\Collection;

readonly class Card
{
    public function __construct(public int $id, public Collection $winning, public Collection $scratched) {}

    public function points(): int
    {
        $matching = $this->scratched->intersect($this->winning);

        if ($matching->isEmpty()) {
            return 0;
        }

        $score = 1;
        for ($x = 1; $x < $matching->count(); ++$x) {
            $score = $score * 2;
        }

        return $score;
    }
}
