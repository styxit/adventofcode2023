<?php

namespace Styxit\Commands;

use Styxit\Input;
use Styxit\InputLoader;
use Styxit\Puzzle;
use Styxit\PuzzlePart;
use Styxit\PuzzleSolutionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'solve')]
class SolvePuzzleCommand extends Command
{
    /**
     * Set command configuration.
     */
    protected function configure()
    {
        $this->setDescription('Solve a puzzle for a specific day.');
        $this->addArgument('day', InputArgument::REQUIRED, 'The day to solve.');
        $this->addOption('example');
    }

    /**
     * Run the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!is_numeric($input->getArgument('day'))) {
            throw new \InvalidArgumentException('No numeric day provided');
        }

        $day = (int) $input->getArgument('day');

        // Create the puzzle.
        $puzzle = $this->getPuzzle($day);

        if ($input->getOption('example')) {
            $input1 = InputLoader::example($day, 1);
            $input2 = InputLoader::example($day, 2);
        } else {
            $input1 = InputLoader::input($day, 1);
            $input2 = InputLoader::input($day, 2);
        }

        // Solve part 1.
        $solution1 = $puzzle->solve(PuzzlePart::ONE, new Input($input1));
        $output->writeln('Solution to part 1: '.$solution1);

        // Solve part 2.
        $solution2 = $puzzle->solve(PuzzlePart::TWO, new Input($input2));
        $output->writeln('Solution to part 2: '.$solution2);

        return 0;
    }

    /**
     * Get the Puzzle with solution for a day.
     *
     * @param int $day The day to solve.
     *
     * @return Puzzle The puzzle with the solution for the day.
     */
    private function getPuzzle(int $day): Puzzle
    {
        // Get the solution class for the requested day.
        $puzzleSolution = $this->getDaySolution($day);

        // Create the puzzle.
        return new Puzzle($puzzleSolution);
    }

    /**
     * Get the Solution for a day.
     *
     * @param int $day The day to solve.
     *
     * @return PuzzleSolutionInterface Instance of the solution.
     */
    private function getDaySolution(int $day): PuzzleSolutionInterface
    {
        // Construct the namespace to the solution.
        $solutionClass = '\Puzzles\Day'.$day.'\Solution';

        if (!class_exists($solutionClass)) {
            throw new \InvalidArgumentException('No solution found for day '.$day);
        }

        // Create solution instance.
        return new $solutionClass();
    }
}
