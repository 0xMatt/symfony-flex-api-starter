<?php

namespace App\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctrineTestCase extends WebTestCase
{
    public function setUp()
    {
        self::bootKernel();
        $entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);
    }
}