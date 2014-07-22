<?php

namespace Grace\Collabs;

use Symfony\Component\Process\ProcessBuilder;

class Helper
{
    public function run($command, $allowFailures = false)
    {
        if (is_string($command)) {
            $command = $this->parseProcessArguments($command);
        }

        $builder = new ProcessBuilder($command);
        $builder
            ->setWorkingDirectory(getcwd())
            ->setTimeout(3600)
        ;
        $process = $builder->getProcess();

        $process->run();

        if (!$process->isSuccessful() && !$allowFailures) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }

    /**
     * @param string $command
     *
     * @return string[]
     *
     * @throws \InvalidArgumentException
     */
    protected function parseProcessArguments($command)
    {
        if (preg_match_all('/((?:"(?:(?:[^"\\\\]|\\\\.)+)")|(?:\'(?:[^\'\\\\]|\\\\.)+\')|[^ ]+)/i', $command, $args)) {
            $normalizeCommandArgument = function ($argument) {
                if ("'" === $argument[0] || '"' === $argument[0]) {
                    $quote = $argument[0];

                    $argument = substr($argument, 1, -1);
                    $argument = str_replace('\\'.$quote, $quote, $argument);
                    $argument = str_replace('\\\\', '\\', $argument);
                }

                return $argument;
            };

            return array_map($normalizeCommandArgument, $args[0]);
        }

        throw new \InvalidArgumentException(sprintf('Unable to parse command "%s".', $command));
    }
}
