<?php

namespace OSS\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class SetupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('oss:setup');
        $this->setDescription('Sets up the game.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('loading all fixtures...........');
        $input = new ArgvInput();
        $input->setInteractive(false);
        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $command->run($input, new NullOutput());
        $output->writeln('<info>OK</info>');

        $output->write('setting up match fixtures......');
        $this->getContainer()->get('oss.core.service.fixture')->createFixtures(1);
        $output->writeln('<info>OK</info>');
    }
}
