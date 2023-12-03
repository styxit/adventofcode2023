<?php

namespace Styxit;

use Illuminate\Support\Collection;

class Input
{
    /**
     * @var string The plain text input.
     */
    private string $plain = '';

    /**
     * @var string The plain text input.
     */
    private array $lines = [];

    /**
     * Loader constructor.
     *
     * @param string $input       The full path to the input file to load.
     * @param mixed  $inputString
     */
    public function __construct($inputString)
    {
        $this->plain = trim($inputString, "\n\r\t\v\x00");
        $this->lines = explode(PHP_EOL, $this->plain);
    }

    /**
     * Input as an array.
     *
     * @return string[] The input separated by line.
     */
    public function lines()
    {
        return $this->lines;
    }

    /**
     * Get the input as a collection.
     *
     * @return Collection Collection with each line as an item.
     */
    public function collection()
    {
        return new Collection($this->lines());
    }

    /**
     * Get plain text input.
     *
     * @return string
     */
    public function plain()
    {
        return $this->plain;
    }
}
