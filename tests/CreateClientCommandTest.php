<?php

namespace App\Tests;

use App\Command\CreateClientCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateClientCommandTest extends DoctrineTestCase
{

    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new CreateClientCommand($kernel->getContainer()));

        $command = $application->find('api:client:create');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['1', 'foo.com']);
        $commandTester->execute(['command' => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertContains('You\'ve enabled: client_credentials', $output);
        $this->assertContains('Added a new client with public id', $output);
    }

    public function testExecuteHandlesMultipleValues()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new CreateClientCommand($kernel->getContainer()));

        $command = $application->find('api:client:create');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['0,2,3', 'foo.com,bar.com']);
        $commandTester->execute(['command' => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertContains('You\'ve enabled: authorization_code, password, refresh_token', $output);
        $this->assertContains('Added a new client with public id', $output);
    }
}