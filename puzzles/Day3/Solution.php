<?php

namespace Puzzles\Day3;

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
        $parts = $this->getParts($input);
        $grid = Grid::fromLines($input->lines());

        $filteredParts = $parts
            // Only leep the Parts that have one or more surrounding Characters.
            ->filter(function (Part $part) use ($grid) {
                return $grid
                    ->getSurrounding($part)
                    ->isNotEmpty();
            });

        // Sum part numbers to get the solution.
        return $filteredParts->sum('number');
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        $parts = $this->getParts($input);
        $grid = Grid::fromLines($input->lines());

        $gears = $parts
            // Find surrounding gear Characters for each part.
            ->map(function (Part $part) use ($grid) {
                return $grid
                    // Surrounding characters.
                    ->getSurrounding($part)
                    // Only keep the gears.
                    ->filter->isGear();
            })
            // Flatten so its a big list of gear Characters (no longer grouped per part).
            ->flatten()
            // Group by id, so the same Characters (gears) are in one collection.
            ->groupBy('id')
            // Only keep the collection of Characters that have exactly 2 gears.
            ->filter(function (Collection $gearCollection) {
                return $gearCollection->count() === 2;
            });

        // For each gear group, multiply the Part numbers to get the ratio.
        $ratios = $gears->map(function (Collection $gears) {
            return array_product(
                $gears
                    ->map(function (Character $gear) {
                        return $gear->connectedPart->number;
                    })
                    ->toArray()
            );
        });

        // Sum all ratios to get the solution.
        return $ratios->sum();
    }

    /**
     * Get collection of (possible) Parts.
     *
     * @param Input $input
     *
     * @return Collection Collection of Parts.
     */
    private function getParts(Input $input): Collection
    {
        return $input->collection()
            ->map(function (string $line, int $row) {
                $coordinates = new Collection();

                preg_match_all(
                    '/\d+/',
                    $line,
                    $matches,
                    PREG_OFFSET_CAPTURE
                );

                foreach ($matches[0] as $match) {
                    [$partNr, $offset] = $match;
                    $coordinates->push(new Part((int) $partNr, new Coordinate($row, $offset)));
                }

                return $coordinates;
            })
            ->flatten();
    }
}
