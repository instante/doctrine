<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;

interface IMigrationStrategy
{
    public function createMigration();
}
