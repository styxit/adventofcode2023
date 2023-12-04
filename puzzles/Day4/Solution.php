<?php

namespace Puzzles\Day4;

use Illuminate\Support\Collection;
use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input)
    {
        $cards = $input->collection()->map(function ($line): Card {
            return $this->cardFromString($line);
        });

        return $cards->map->points()->sum();
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        return 0;
    }

    /**
     * Turn input line into a Card with the winning and scratched numbers.
     *
     * @param string $inputString
     *
     * @return Card
     */
    private function cardFromString(string $inputString): Card
    {
        [$empty, $cardId, $winningNumbers, $scratchedNumbers] = preg_split(
            '/Card\s+|\:\s+|\s+\|\s+/',
            $inputString
        );

        // Turn number string into a collection of individual numbers.
        $winningNumbers = new Collection(array_map('intval', preg_split('/\s+/', $winningNumbers)));
        $scratchedNumbers = new Collection(array_map('intval', preg_split('/\s+/', $scratchedNumbers)));

        return new Card((int) $cardId, $winningNumbers, $scratchedNumbers);
    }
}
