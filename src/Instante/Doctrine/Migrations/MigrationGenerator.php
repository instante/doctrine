<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\ORM\EntityManager;
use Nette\NotImplementedException;

class MigrationGenerator
{
    /** @var EntityManager */
    private $em;

    /** @var string */
    private $migrationsDir;

    /** @var string * for version number */
    private $migrationFilesMask = 'Version*.php';

    /** @var string */
    private $schemaFile = 'schema.php';

    /**
     * @param EntityManager $em
     * @param string $migrationsDir
     */
    public function __construct(EntityManager $em, $migrationsDir)
    {
        $this->em = $em;
        $this->migrationsDir = $migrationsDir;
    }


    /**
     * 1. read `migrations/schema.yml` -> FROM
     * 2. read current schema loaded from current schema reader to EntityManager -> TO
     * 3. export TO -> migrations/schema.?:
     *    - database schema
     *    - version chain (list of migration files to achieve this state)
     * 4. create new migration version into migrations/Version*.php
     */
    public function generate()
    {
        throw new NotImplementedException;
    }
}
