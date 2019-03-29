<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SecondCommand extends Command
{
    protected static $defaultName = 'app:second-command';

    protected function configure()
    {
        $this
            ->setDescription('A command to call a command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        if ( !( $command = $this->getApplication()->find('app:my-command') ) ) {
            $io->error('No se encuentra el comando app:my-command');
        } else {
            $arguments = new ArrayInput([
                'longitud' => 3,
            ]);

            $returnCode = $command->run( $arguments, $output );
            $io->success('El comando devolvio '.$returnCode);
        }
    }
}
