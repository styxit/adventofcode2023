<?php

namespace Puzzles\Day1;

enum Numbers: int
{
    case one = 1;
    case two = 2;
    case three = 3;
    case four = 4;
    case five = 5;
    case six = 6;
    case seven = 7;
    case eight = 8;
    case nine = 9;

    public static function fromString(string $name)
    {
        return constant("self::{$name}");
    }
}
