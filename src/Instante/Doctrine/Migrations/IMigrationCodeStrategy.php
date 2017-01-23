<?php

namespace Instante\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;

interface IMigrationCodeStrategy
{
    /**
     * @param Schema $from
     * @param Schema $to
     * @param string $versionName
     * @return string php code
     */
    public function generate(Schema $from, Schema $to, $versionName);
}
