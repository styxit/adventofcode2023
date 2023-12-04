<?php

namespace Puzzles\Day4;

use Illuminate\Support\Collection;

class Card
{
    public int $instances = 1;

    public function __construct(readonly public int $id, readonly public Collection $winning, readonly public Collection $scratched) {}

    public function points(): int
    {
        $matching = $this->scratched->intersect($this->winning);

        if ($matching->isEmpty()) {
            return 0;
        }

        $score = 1;
        // For each match, multiply the score by 2.
        for ($x = 1; $x < $matching->count(); ++$x) {
            $score = $score * 2;
        }

        return $score;
    }

    /**
     * Collection where the key is the card number that was won.
     * The value is the Nr of instances won.
     *
     * @return Collection
     */
    public function prize(): Collection
    {
        $matching = $this->scratched->intersect($this->winning);

        $wonCardNumbers = new Collection();
        if ($matching->isEmpty()) {
            return $wonCardNumbers;
        }

        // If 4 cards are won, the next four card IDs are considered won.
        $wonNumbers = range(
            $this->id + 1, // The next card ID.
            $this->id + $matching->count()
        );

        foreach ($wonNumbers as $wonNumber) {
            // Multiple instancs of the same card can be won.
            $wonCardNumbers->put($wonNumber, $this->instances);
        }

        return $wonCardNumbers;
    }
}
