<?php

namespace App\Command;

use App\Entity\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ClientListCommand extends Command
{
    protected static $defaultName = 'api:client:list';

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
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('api:client:list')
            ->setDescription('Lists current API clients.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clients = $this->container->get('doctrine')->getRepository(Client::class)->findAll();
        $table = new Table($output);
        $table->setHeaders(['ID', 'Key', 'Secret', 'Grant Types', 'Redirect URIs']);
        /** @var Client $client */
        foreach($clients as $client) {
            $table->addRow([
                'id' => $client->getId(),
                'key' => $client->getPublicId(),
                'secret' => $client->getSecret(),
                'grant_types' => implode(',', $client->getAllowedGrantTypes()),
                'redirect_uris' => implode(',', $client->getRedirectUris()),
            ]);
        }
        $table->render();
    }

}
