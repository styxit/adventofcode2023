<?php

namespace Puzzles\Day1;

use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input)
    {
        return $input
            ->collection()
            ->map($this->getCalibrationValuesFromDigits(...))
            ->sum();
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        return $input
            ->collection()
            ->map($this->getCalibrationValuesFromText(...))
            ->sum();
    }

    /**
     * Get the first and last number.
     * Uses digits only.
     *
     * @param string $calibration
     */
    private function getCalibrationValuesFromDigits(string $calibration): int
    {
        $numbers = preg_replace('/[^1-9.]+/', '', $calibration);

        return (int) ($numbers[0].$numbers[-1]);
    }

    /**
     * Get the first and last number.
     * Uses digits and text to detect numbers.
     *
     * @param string $calibration
     */
    private function getCalibrationValuesFromText(string $calibration): int
    {
        /*
         * Use Positive lookahead regex to also cover overlapping cases like "eightwo".
         * Regex matches numbers as digits and all numbers as text (like one, two, etc).
         */
        // Get array of all numbers as text.
        $textNumbers = array_map(
            fn ($number) => $number->name,
            Numbers::cases(),
        );
        $regex = sprintf('/(?=([1-9]|%s))/', implode('|', $textNumbers));

        preg_match_all($regex, $calibration, $matches);

        // Get the first and last number. Can be either numeric (3) or text(three).
        $first = reset($matches[1]);
        $last = end($matches[1]);

        return (int) ($this->textToNumber($first).$this->textToNumber($last));
    }

    /**
     * Convert text representation of a number to int.
     *
     * @param string $numberString The number to turn to int.
     *
     * @return int The number
     */
    private function textToNumber(string $numberString): int
    {
        if (is_numeric($numberString)) {
            return (int) $numberString;
        }

        return Numbers::fromString($numberString)->value;
    }
}
