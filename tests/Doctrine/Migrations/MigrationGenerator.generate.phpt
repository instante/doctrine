<?php

namespace Instante\Tests\Doctrine\Migrations;

use Instante\Doctrine\Migrations\MigrationGenerator;
use Tester\Assert;
use Tester\Environment;

function migrationExists() {
    return count(glob(TEMP_DIR . '/migrations/Version*.php')) > 0;
}

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/testEmFactory.php';

Environment::skip('TODO MigrationGenerator::generate()');

$em = createTestEntityManager();
$mg = new MigrationGenerator($em, TEMP_DIR . '/migrations');
Assert::false(migrationExists());
$mg->generate();
Assert::true(migrationExists());

