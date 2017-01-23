<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\Provider\OrmSchemaProvider;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Kdyby\Doctrine\EntityManager;

class MigrationBuilder //implements ISchemaUpdateTask
{
    /** @var EntityManager */
    public $em;

    /** @var string */
    public $pathToSchema;

    /**
     * SchemaFileBuilder constructor.
     * @param EntityManager $em
     * @param $pathToSchema
     */
    public function __construct(EntityManager $em, $pathToSchema)
    {
        $this->em = $em;
        $this->pathToSchema = $pathToSchema;
    }

    // fyzicky vytvori soubor s migracemi
    public function build(/**Schema $from, Schema $to**/)
    {
        // problem - nenacte spravna data z yml
        $from = $this->getFromSchema();
        $to = $this->getToSchema();

        dump($from);
        dump($to);

        $platform = $this->em->getConnection()->getDatabasePlatform();

        $diff = $from->getMigrateToSql($to, $platform);
        dump($diff);

        $diff = $from->getMigrateFromSql($to, $platform);
        dump($diff);

        // @todo - vytvorit soubor s migracemi - podobne jako diff command
    }

    /**
     * @return Schema
     */
    private function getToSchema()
    {
        $orm = new OrmSchemaProvider($this->em);

        return $orm->createSchema();
    }

    /**
     * @return Schema
     */
    private function getFromSchema()
    {
        $driver = new YamlDriver([$this->pathToSchema]);
        $this->em->getConfiguration()->setMetadataDriverImpl($driver);

        $orm = new OrmSchemaProvider($this->em);
        return $orm->createSchema();
    }
}
