<?php

namespace OSS\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class SetupCommand extends ContainerAwareCommand
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    protected function configure()
    {
        $this->setName('oss:setup');
        $this->setDescription('Sets up the game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->executeCommand('doctrine:schema:drop', 'dropping database schema', '--force');
        $this->executeCommand('doctrine:schema:create', 'creating database schema');
        $this->executeCommand('doctrine:fixtures:load', 'loading all fixtures');
        $this->setUpMatchFixtures($output);
    }

    /**
     * @param string $commandName
     * @param string $message
     * @param string $params
     *
     * @throws \Exception
     */
    private function executeCommand($commandName, $message, $params = '')
    {
        $this->commandStart($message);
        $command = $this->getApplication()->find($commandName);
        $input = array('command' => $commandName);
        if (!empty($params)) {
            $input[$params] = true;
        }
        $arrayInput = new ArrayInput($input);
        $arrayInput->setInteractive(false);
        $command->run($arrayInput, new NullOutput());
        $this->output->writeln('<info>OK</info>');
    }

    private function setUpMatchFixtures()
    {
        $this->commandStart('setting up match fixtures');
        $this->getContainer()->get('oss.core.service.fixture')->createFixtures(1);
        $this->output->writeln('<info>OK</info>');
    }

    /**
     * @param string $message
     */
    private function commandStart($message)
    {
        $this->output->write($message . substr('..................................................', 0, 50 - strlen($message)));
    }
}
