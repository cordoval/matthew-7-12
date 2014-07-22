<?php

namespace Grace\Collabs;

use Symfony\Component\Process\ProcessBuilder;

class Helper
{
    public function run($command, $allowFailures = true)
    {
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
}
