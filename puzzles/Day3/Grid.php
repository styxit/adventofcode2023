<?php

namespace Puzzles\Day3;

use Illuminate\Support\Collection;

class Grid extends Collection
{
    public static function fromLines($items = [])
    {
        $grid = array_map(
            fn ($line) => new Collection(str_split($line)),
            $items
        );

        return new static($grid);
    }

    public function getSurrounding(Part $part): Collection
    {
        $partNumberLength = strlen((string) $part->number);

        $rowNr = $part->startCoordinate->row;
        $row = $this->get($rowNr);
        $rowAbove = $this->get($rowNr - 1);
        $rowBelow = $this->get($rowNr + 1);

        $maxColumn = $row->count() - 1;
        $startColumn = $part->startCoordinate->column ? $part->startCoordinate->column - 1 : 0;
        $endColumn = $part->startCoordinate->column + $partNumberLength;

        $surrounding = new Collection();

        // Above.
        if ($rowAbove) {
            $surroundingAbove = $rowAbove->only(range($startColumn, $endColumn));
            foreach ($surroundingAbove as $column => $character) {
                $surrounding->add($this->getCharacter($character, $part, new Coordinate($rowNr - 1, $column)));
            }
        }

        // Left.
        if ($part->startCoordinate->column != 0) {
            $surrounding->add($this->getCharacter($row[$startColumn], $part, new Coordinate($rowNr, $startColumn)));
        }

        // Right.
        if ($endColumn <= $maxColumn) {
            $surrounding->add($this->getCharacter($row[$endColumn], $part, new Coordinate($rowNr, $endColumn)));
        }

        // Below.
        if ($rowBelow) {
            $surroundingBottom = $rowBelow->only(range($startColumn, $endColumn));
            foreach ($surroundingBottom as $column => $character) {
                $surrounding->add($this->getCharacter($character, $part, new Coordinate($rowNr + 1, $column)));
            }
        }

        return $surrounding->filter();
    }

    private function getCharacter(string $character, Part $part, Coordinate $coordinate): ?Character
    {
        if ($character === '.') {
            return null;
        }

        return new Character($character, $part, $coordinate);
    }
}
