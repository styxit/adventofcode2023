<?php

namespace Puzzles\Day3;

readonly class Character
{
    public string $id;

    public function __construct(public string $character, public Part $connectedPart, private Coordinate $coordinate)
    {
        $this->id = sha1($this->coordinate->row.'_'.$this->coordinate->column);
    }

    public function isGear()
    {
        return $this->character === '*';
    }
}
