<?php

namespace Puzzles\Day2;

use Illuminate\Support\Collection;

class Game
{
    public function __construct(public int $gameId, public Collection $reveals) {}
}
