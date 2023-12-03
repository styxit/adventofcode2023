<?php

namespace Puzzles\Day2;

use Illuminate\Support\Collection;
use Styxit\Input;
use Styxit\PuzzleSolutionInterface;

class Solution implements PuzzleSolutionInterface
{
    public const RED = 12;
    public const GREEN = 13;
    public const BLUE = 14;

    /**
     * Find the solution for part 1.
     */
    public function solution1(Input $input)
    {
        $games = $input->collection()
            ->map($this->stringToGame(...))
            ->filter(function (Game $game) {
                $exceeds = $game->reveals->first(function ($cubes) {
                    return $cubes->red > self::RED || $cubes->blue > self::BLUE || $cubes->green > self::GREEN;
                });

                return is_null($exceeds);
            });

        return $games->sum('gameId');
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        $games = $input->collection()
            ->map($this->stringToGame(...))
            ->map(function (Game $game) {
                $minimumCubeCollection = $game->reveals->reduce(
                    function ($carry, $cubes) {
                        return new CubeCollection(
                            red: max($carry->red, $cubes->red),
                            green: max($carry->green, $cubes->green),
                            blue: max($carry->blue, $cubes->blue),
                        );
                    },
                    new CubeCollection()
                );

                return $minimumCubeCollection->red * $minimumCubeCollection->green * $minimumCubeCollection->blue;
            });

        return $games->sum();
    }

    private function stringToGame(string $input): Game
    {
        [$gameId, $revealString] = explode(':', $input);

        $gameId = (int) trim($gameId, " \n\r\t\v\x00Game");

        $reveals = (new Collection(explode(';', $revealString)))
            ->map(function (string $cubesString): CubeCollection {
                $cubes = new CubeCollection();

                foreach (explode(', ', trim($cubesString)) as $cube) {
                    [$amount, $color] = explode(' ', $cube);
                    $cubes->{$color} = (int) $amount;
                }

                return $cubes;
            });

        return new Game($gameId, $reveals);
    }
}
