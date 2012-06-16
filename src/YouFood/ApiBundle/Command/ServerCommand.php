<?php

namespace YouFood\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\Connection;

use Predis\Async\Client as PredisAsync;

use YouFood\ApiBundle\Command\Handler\ConnectionHandler;

/**
 * ServerCommand
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ServerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('youfood:server')
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, null, "127.0.0.1")
            ->addOption('port', 'p', InputOption::VALUE_OPTIONAL, null, 16350)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('default_socket_timeout', 0);

        $loop = Factory::create();
        $server = new Server($loop);

        $server->on('connect', function (Connection $connection) use ($loop, $output) {
            $redis = new PredisAsync('tcp://127.0.0.1:6379', $loop);
            $connectionHandler = new ConnectionHandler($redis, $connection);
            $connectionHandler->bindEvents();
        });

        $server->listen($input->getOption('port'), $input->getOption('host'));
        $output->writeln(sprintf('Listening on %d', $input->getOption('port')));

        $loop->run();
    }
}
