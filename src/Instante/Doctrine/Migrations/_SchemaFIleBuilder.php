<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\ORM\Tools\Export\Driver\AbstractExporter;
use Doctrine\ORM\Tools\Export\Driver\YamlExporter;
use Kdyby\Doctrine\EntityManager;

class SchemaFileBuilder //implements ISchemaUpdateTask
{
    /** @var EntityManager */
    public $em;

    /** @var AbstractExporter */
    private $exporter;

    /**
     * SchemaFileBuilder constructor.
     * @param EntityManager $em
     * @param $pathToSchema
     */
    public function __construct(EntityManager $em, $pathToSchema)
    {
        $this->em = $em;

        $this->setupExporter($pathToSchema);
    }

    private function setupExporter($pathToSchema)
    {
        $this->exporter = new YamlExporter($pathToSchema);
        $this->exporter->setOverwriteExistingFiles(true);

        return $this;
    }

    // nepracuji se schema $from a $to
    // -> $from nepotrebuji
    // -> z $to a obecne ze schematu neumim vytahnout metadata
    public function build()
    {
        $metadata = $this->em->getMetadataFactory()->getAllMetadata();

        $this->exporter->setMetadata($metadata);
        $this->exporter->export();
    }
}
