<?php

namespace Grace\PushCode;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class ReaderCommand extends Command
{
    protected $reader;

    public function __construct(
        Reader $reader
    ) {
        parent::__construct();

        $this->reader = $reader;
    }

    protected function configure()
    {
        $this
            ->setName('grace:read')
            ->setDescription('Polls the imap server for incoming new emails not flagged PUSHED')
            ->setHelp(
                <<<EOF
Polls the imap server for incoming new emails not flagged PUSHED.

<comment>Basic usage examples</comment>:
    <info>php console %command.name%</info>

EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectName = 'cordoval/matthew-7-12';
        $messageOrFalse = $this->reader->__invoke($projectName);

        ladybug_dump_die($message);
    }
}
