<?php

namespace App\Tests;

use App\Command\ClientListCommand;
use App\Tests\DoctrineTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ClientListCommandTest extends DoctrineTestCase
{

    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add(new ClientListCommand($kernel->getContainer()));

        $command = $application->find('api:client:list');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertContains('ID', $output);
    }

}