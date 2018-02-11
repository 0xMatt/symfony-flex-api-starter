<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CreateClientCommand extends Command
{
    protected static $defaultName = 'api:client:create';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ApiCreateClientCommand constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('api:client:create')
            ->setDescription('Creates a new client');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select your desired grant types)', [
                'authorization_code',
                'client_credentials',
                'password',
                'refresh_token'
            ]
        );
        $question->setMultiselect(true);

        $types = $helper->ask($input, $output, $question);
        $output->writeln('You\'ve enabled: ' . implode(', ', $types));

        $question = new Question("Please enter your redirect uris. Separate multiple with commas: \n");
        $redirectUris = $helper->ask($input, $output, $question);

        $clientManager = $this->container->get('api.client_manager.default');
        $client = $clientManager->createClient();
        if(strpos($redirectUris, ',') !== false) {
            $client->setRedirectUris(explode(',', $redirectUris));
        }
        else {
            $client->setRedirectUris([$redirectUris]);
        }
        $client->setAllowedGrantTypes($types);
        $clientManager->updateClient($client);
        $output->writeln(
            sprintf(
                'Added a new client with public id <info>%s</info>, secret <info>%s</info>',
                $client->getPublicId(),
                $client->getSecret()
            )
        );
    }

}
