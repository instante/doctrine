<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\Provider\OrmSchemaProvider;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Nette\NotImplementedException;

class SchemaFileMigrationStrategy implements IMigrationStrategy
{
    /** @var EntityManager */
    private $entityManager;

    /** @var string */
    private $migrationsDir;

    /** @var string * for version number */
    private $migrationFilesMask = 'Version*.php';

    /** @var string */
    private $schemaFile = 'schema.php';

    /** @var IVersionNamingStrategy */
    private $versionNamingStrategy;

    /** @var IMigrationCodeStrategy */
    private $migrationCodeStrategy;

    /**
     * @param EntityManager $em
     * @param IVersionNamingStrategy $versionNamingStrategy
     * @param IMigrationCodeStrategy $migrationCodeStrategy
     * @param string $migrationsDir
     */
    public function __construct(
        EntityManager $em,
        IVersionNamingStrategy $versionNamingStrategy,
        IMigrationCodeStrategy $migrationCodeStrategy,
        $migrationsDir
    ) {
        $this->entityManager = $em;
        $this->migrationsDir = $migrationsDir;
        $this->versionNamingStrategy = $versionNamingStrategy;
        $this->migrationCodeStrategy = $migrationCodeStrategy;
    }


    /**
     * 1. read `migrations/schema.yml` -> FROM
     * 2. read current schema loaded from current schema reader to EntityManager -> TO
     * 3. create new migration version into migrations/Version*.php
     * 4. export TO -> $this->schemaFile:
     */
    public function createMigration()
    {
        $fileSchema = $this->getFileSchema();
        $versionChain = $fileSchema->getVersionChain();
        $from = $fileSchema->getSchema($this->entityManager);
        $to = $this->getEntityManagerSchema();
        $newVersionName = $this->versionNamingStrategy->createNewVersionName($versionChain);

        $migration = $this->createMigrationBetween($from, $to, $newVersionName);
        $versionChain[] = $newVersionName;
        $schema = SchemaExporter::export($this->entityManager, $versionChain);
        $this->saveMigrationFile($migration, $newVersionName);
        $this->saveSchemaFile($schema);
    }

    private function createMigrationBetween(Schema $from, Schema $to, $versionName)
    {
        throw new NotImplementedException();
    }

    private function getSchemaFilePath()
    {
        return $this->migrationsDir . '/' . $this->schemaFile;
    }

    private function getEntityManagerSchema()
    {
        $provider = new OrmSchemaProvider($this->entityManager);
        return $provider->createSchema();
    }

    /** @return FileSchema */
    private function getFileSchema()
    {
        $schemaFilePath = $this->getSchemaFilePath();
        if (is_file($schemaFilePath)) {
            return require $schemaFilePath;
        } else {
            return FileSchema::createEmpty();
        }
    }

    private function saveSchemaFile($exportedSchema)
    {
        file_put_contents($this->getSchemaFilePath(), $exportedSchema);
    }

    private function saveMigrationFile($code, $version)
    {
        file_put_contents($this->getMigrationFilePath($version), $code);
    }

    private function getMigrationFilePath($version)
    {
        return
            $this->migrationsDir
            . '/'
            . str_replace('*', $version, $this->migrationFilesMask);
    }
}
