<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Post;
use Symfony\Component\Routing\RouterInterface;

class MyCommand extends Command
{
    protected static $defaultName = 'app:my-command';
    private $entityManager;
    private $router;

    public function __construct( EntityManagerInterface $entityManager, RouterInterface $router, ?string $name = null)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
//        $router->getContext()->setBaseUrl('http://localhost:8000');

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Mi primer comando')
            ->addArgument('longitud', InputArgument::REQUIRED, 'Longitud en metros')
            ->addOption('largo', null, InputOption::VALUE_NONE, 'Largo o ancho')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('longitud');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ( $option = $input->getOption('largo') ) {
            $io->note('Ejecutando con la opción '.$option);
        }

        $io->note('La url para ver posts es '.$this->router->generate('post'));

        return 0;
    }
}
