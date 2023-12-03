<?php

namespace Styxit;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

class InputLoader
{
    /**
     * @var string Define path to the input or example file.
     */
    public const INPUT_ROOT = __DIR__.'/../puzzles/Day%d/input/%s';

    public static function input(int $day, ?int $inputNr = null)
    {
        return self::loadInput($day, 'input', $inputNr);
    }

    public static function example(int $day, ?int $exampleNr = null)
    {
        return self::loadInput($day, 'example', $exampleNr);
    }

    private static function loadInput(int $day, string $fileNameBase, ?int $nr = null)
    {
        $fileName = $fileNameBase.$nr.'.txt';

        $path = self::getFilePath($day, $fileName);

        if (!file_exists($path) && $nr) {
            return self::loadInput($day, $fileNameBase);
        }
        if (!file_exists($path)) {
            throw new FileNotFoundException('Input file does not exists.');
        }

        return file_get_contents($path);
    }

    /**
     * Get the input file based on the current Solution instance.
     *
     * @param bool $example Load example input.
     *
     * @return string The full path where the input file should be located.
     */
    private static function getFilePath(int $day, string $fileName)
    {
        return sprintf(self::INPUT_ROOT, $day, $fileName);
    }
}
