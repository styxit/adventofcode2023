<?php

namespace Styxit;

class Puzzle
{
    public function __construct(private PuzzleSolutionInterface $solution) {}

    public function solve(PuzzlePart $part, Input $input)
    {
        return match ($part) {
            PuzzlePart::ONE => $this->solution->solution1($input),
            PuzzlePart::TWO => $this->solution->solution2($input)
        };
    }
}
