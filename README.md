# Advent of Code 2023
Advent of Code 2023 solutions. https://adventofcode.com/

## 🛠 Setup
- `composer install`

## 💻 Usage
To get the solution for day 2, run.
```
 ./aoc solve 2
```

## 👷 Adding a new solution
To create a new solution for day `28` do the following (replace 28 with the number of your day):
- Store the input in `puzzles/Day28/input.txt`. If the input for part 1 and 2 is not the same, use `input1.txt` and `input2.txt`.
- Create a new Solution for the day `puzzles/Day28/Solution.php` That implements the `Styxit\PuzzleSolutionInterface` interface.
- Write the `solution1(Input $input)` and `solution2(Input $input)` methods that return the solutions for part 1 and part 2.

In the Solution class, the puzzle input is provided as the first argument. Yse `$input` to get access to the parsed input.

Solve the puzzle with
```
 ./aoc solve 28
```

### Example data
The example data for the puzzle can be stored in `puzzles/Day28/example.txt`. If the example input for part 1 and 2 is not the same, use `example1.txt` and `example2.txt`. After that, use the `--example` option to use the example data as input.

Solve the puzzle using example data.
```
 ./aoc solve 28 --example
```

## 🐞 Testing
For each solution a test can be written to make sure the output is correct. By extending the `AbstractDayTester` only the (example) solutions need to be defined. To test the solution for a new day, add a test in the `tests/Solutions` dir, call it `Day28Test.php`.

```
<?php

namespace Tests\Solutions;

/**
 * @internal
 */
class Day28Test extends AbstractDayTester
{
    protected $solutionPart1 = 123;
    protected $solutionPart2 = 0; // Part 2 not yet solved.

    protected $exampleSolution1 = 456;
    protected $exampleSolution2 = 0; // Part 2 not yet solved.
}
```

Run all tests: 
```
./vendor/bin/phpunit --testdox tests
```
