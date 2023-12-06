<?php

namespace Puzzles\Day6;

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
        $raceRecords = $this->getRaceRecordsFromInput($input);

        $waysToBeat = $raceRecords->map(function ($race) {
            return $this->getRaceWins($race['time'], $race['distance']);
        });

        return array_product($waysToBeat->toArray());
    }

    /**
     * Find the solution for part 2.
     */
    public function solution2(Input $input)
    {
        $raceTime = $this->getCombinedNumberFromString($input->lines()[0]);
        $raceDistance = $this->getCombinedNumberFromString($input->lines()[1]);

        return $this->getRaceWins($raceTime, $raceDistance);
    }

    private function getRaceWins(int $time, int $recordDistance)
    {
        $winCount = 0;

        // Skip the first microseconds that will definately not finish to reduce the number of needed calculations.
        $startMs = (int) floor($recordDistance / $time + 1);

        for ($ms = $startMs; $ms < $time; ++$ms) {
            $speed = $ms;
            $duration = $time - $ms;
            $distance = $speed * $duration;

            if ($distance > $recordDistance) {
                ++$winCount;
            }
        }

        return $winCount;
    }

    private function getCombinedNumberFromString(string $inputString): int
    {
        return (int) preg_replace('/\D/', '', $inputString);
    }

    private function getRaceRecordsFromInput(Input $inputString): Collection
    {
        $timeString = $inputString->lines()[0];
        $distanceString = $inputString->lines()[1];

        // Turn number string into a collection of individual numbers.
        $times = new Collection(array_map('intval', preg_split('/\s+/', $timeString)));
        unset($times[0]);

        $distances = new Collection(array_map('intval', preg_split('/\s+/', $distanceString)));
        unset($distances[0]);

        $records = new Collection();
        foreach ($times as $key => $time) {
            $records->add([
                'time' => $time,
                'distance' => $distances[$key],
            ]);
        }

        return $records;
    }
}
