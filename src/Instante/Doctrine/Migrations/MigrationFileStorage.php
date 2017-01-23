<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\Provider\SchemaProviderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class MigrationFileStorage implements SchemaProviderInterface
{
    /** @var string */
    private $schemaFilePath;

    /** @var EntityManager */
    private $entityManager;

    /**
     * @param string $schemaFilePath
     * @param EntityManager $entityManager
     */
    public function __construct($schemaFilePath, EntityManager $entityManager)
    {
        $this->schemaFilePath = $schemaFilePath;
        $this->entityManager = $entityManager;
    }


    /**
     * Create the schema to which the database should be migrated.
     *
     * @return  \Doctrine\DBAL\Schema\Schema
     */


    public function saveEntityManagerSchema()
    {
        $exporter = new SchemaExporter();
        file_put_contents($this->schemaFilePath, SchemaExporter::export($this->entityManager));
    }
}
